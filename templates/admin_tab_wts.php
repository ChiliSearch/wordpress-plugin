<?php
$siteInfo           = $this->get_website_info();
$plan               = $this->get_current_plan();
$documentCountLimit = isset( $siteInfo['documentCountLimit'] ) ? (int) $siteInfo['documentCountLimit'] : null;

$post_types = get_post_types( [ 'public' => true ], false );
if ( isset( $post_types['product'] ) ) {
    $post_types['product_instock']        = clone $post_types['product'];
    $post_types['product_instock']->name  = 'product_instock';
    $post_types['product_instock']->label = __( 'Instock Products', 'chilisearch' );
    $post_types['product_instock']->link  = esc_url( admin_url( 'edit.php?post_status=publish&post_type=product&stock_status=instock' ) );

    $post_types['product_outofstock']        = clone $post_types['product'];
    $post_types['product_outofstock']->name  = 'product_outofstock';
    $post_types['product_outofstock']->label = __( 'Out-of-stock Products', 'chilisearch' );
    $post_types['product_outofstock']->link  = esc_url( admin_url( 'edit.php?post_status=publish&post_type=product&stock_status=outofstock' ) );
}
unset( $post_types['product'], $post_types['attachment'] );
?>
<style>
    .form-group {
        padding: 3px 0;
    }
    .form-group label span {
        background: #d7e8d8;
        color: #005a05;
        padding: 2px;
        font-size: smaller;
    }
</style>
<div class="wrap">
    <form method="post" action="options.php" id="site_index_config">
        <?php settings_fields( 'chilisearch_wts_settings_group' ); ?>
        <table class="form-table">
            <tbody>
            <tr valign="top">
                <th scope="row"><label><?= __( 'Search between', 'chilisearch' ) ?>:</label></th>
                <td>
                    <?php foreach ( $post_types as $post_type): ?>
                        <div class="form-group">
                            <label for="<?= $post_type->name ?>">
                                <input type="checkbox" name="chilisearch_wtf_settings[<?= $post_type->name ?>]" id="<?= $post_type->name ?>" <?= ! empty( $this->wts_settings[ $post_type->name ] ) ? 'checked' : '' ?>>
                                <?= $post_type->label ?>
                                <small><a href="<?= ! empty( $post_type->link ) ? $post_type->link : esc_url( admin_url( 'edit.php?post_status=publish&post_type=' . $post_type->name ) ) ?>" target="_blank"></a></small>
                            </label>
                        </div>
                    <?php endforeach; ?>
                    <div class="form-group">
                        <label for="media_doc_files">
                            <input type="checkbox" name="chilisearch_wtf_settings[media_doc_files]" id="media_doc_files" <?= $this->wts_settings['media_doc_files'] ? 'checked' : '' ?> <?php if ($plan !== 'premium'): ?>disabled="disabled"<?php endif; ?>>
                            <?= __( 'Inside document files (doc, docx, pptx, pdf, xlsx, …)', 'chilisearch' ) ?>
                            <small><a href="<?= esc_url( admin_url( 'upload.php?post_mime_type=application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/vnd.ms-word.document.macroEnabled.12,application/vnd.ms-word.template.macroEnabled.12,application/vnd.oasis.opendocument.text,application/vnd.apple.pages,application/pdf,application/vnd.ms-xpsdocument,application/oxps,application/rtf,application/wordperfect,application/octet-stream' ) ) ?>" target="_blank"></a></small>
                            <?php if ($plan !== 'premium'): ?><a target="_blank" href="<?= esc_url( admin_url( 'admin.php?page=chilisearch&tab=license' ) ) ?>"><span>(<?= __('premium only', 'chilisearch') ?>)</span></a><?php endif; ?>
                        </label>
                    </div>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row"><label><?= __( 'Reindex', 'chilisearch' ) ?></label></th>
                <td>
                    <label>
                        <input type="checkbox" name="reindex" id="reindex">
                        <?= __( 'Reindex all documents', 'chilisearch' ) ?>
                        <p class="description"><?= __( 'Used when shown documents in search result are not updated.', 'chilisearch' ) ?></p>
                    </label>
                </td>
            </tr>
            </tbody>
        </table>
        <p>
            <?= sprintf(__('You can index upto %d documents in "%s" plan.', 'chilisearch'), $documentCountLimit, $plan) ?>
            <a href="<?= admin_url( 'admin.php?page=chilisearch&tab=license' ) ?>" target="_blank"><?= __('Need more?', 'chilisearch') ?></a>
        </p>
        <div style="display: flex;">
            <input type="hidden" name="action" value="admin_ajax_index_config">
            <?php submit_button(); ?>
            <span style="align-self:center;" id="get_post_counts_spinner" class="spinner is-active"></span>
        </div>
    </form>
</div>
<script type="text/javascript">
    var wordpressPostsCount = []

    jQuery(document).ready(function ($) {
        jQuery.post(
            ajaxurl,
            {
                'action': 'admin_ajax_get_posts_count',
            },
            function (response) {
                if (response.status) {
                    wordpressPostsCount = response.posts_count
                    jQuery('#get_post_counts_spinner').hide();
                    for (let postType in wordpressPostsCount) {
                        jQuery(`label[for="${postType}"] small a`).text(`(${wordpressPostsCount[postType]})`)
                    }
                    return;
                }
                alert(response.message);
            }
        );
        jQuery('#site_index_config').submit(function (e) {
            e.preventDefault();
            jQuery('#get_post_counts_spinner').show();
            let reindex = jQuery('#site_index_config #reindex').is(":checked")
            jQuery('#site_index_config button[type="submit"]').prop('disabled', true)
            jQuery.post(
                ajaxurl,
                jQuery(this).serialize(),
                function (response) {
                    if (response.status) {
                        window.location.replace("<?= admin_url( 'admin.php?page=chilisearch&tab=indexing' . ( isset( $_GET['get-started'] ) ? '&get-started' : '' ) ) ?>" + (reindex ? '&reindex' : ''));
                        return;
                    }
                    jQuery('#site_index_config button[type="submit"]').prop('disabled', false)
                    jQuery('#get_post_counts_spinner').hide();
                    alert(response.message);
                }
            );
            return false;
        });
    });
</script>
