<style>
    .form-group > ul {
        padding: 0 40px;
        margin: 0;
    }
</style>
<div class="wrap">
    <h2><?= __( 'Choose where to search', 'chilisearch' ) ?></h2>
    <form method="post" action="options.php" id="site_index_config">
        <?php settings_fields( 'chilisearch_wts_settings_group' ); ?>
        <table class="form-table">
            <tbody>
            <tr valign="top">
                <th scope="row"><label><?= __( 'Search between', 'chilisearch' ) ?>:</label></th>
                <td>
                    <div class="form-group">
                        <label for="posts">
                            <input type="checkbox" name="chilisearch_wtf_settings[posts]" id="posts" <?= $this->wts_settings['posts'] ? 'checked' : '' ?>>
                            <?= __( 'Posts', 'chilisearch' ) ?>
                            <small><a href="<?= esc_url( admin_url( 'edit.php?post_status=publish&post_type=post' ) ) ?>" target="_blank"></a></small>
                        </label>
                        <ul>
                            <li class="mb-0">
                                <label class="mb-0" for="posts_approved_comments">
                                    <input type="checkbox" name="chilisearch_wtf_settings[posts_approved_comments]" id="posts_approved_comments" <?= $this->wts_settings['posts_approved_comments'] ? 'checked' : '' ?> disabled="disabled">
                                    <?= __( 'Approved comments', 'chilisearch' ) ?>
                                    <small><a href="<?= esc_url( admin_url( 'edit-comments.php?comment_status=approved&post_type=post' ) ) ?>" target="_blank"></a></small>
                                </label>
                            </li>
                        </ul>
                    </div>
                    <div class="form-group">
                        <label for="pages">
                            <input type="checkbox" name="chilisearch_wtf_settings[pages]" id="pages" <?= $this->wts_settings['pages'] ? 'checked' : '' ?>>
                            <?= __( 'Pages', 'chilisearch' ) ?>
                            <small><a href="<?= esc_url( admin_url( 'edit.php?post_status=publish&post_type=page' ) ) ?>" target="_blank"></a></small>
                        </label>
                        <ul>
                            <li class="mb-0">
                                <label class="mb-0" for="pages_approved_comments">
                                    <input type="checkbox" name="chilisearch_wtf_settings[pages_approved_comments]" id="pages_approved_comments" <?= $this->wts_settings['pages_approved_comments'] ? 'checked' : '' ?> disabled="disabled">
                                    <?= __( 'Approved comments', 'chilisearch' ) ?>
                                    <small><a href="<?= esc_url( admin_url( 'edit-comments.php?comment_status=approved&post_type=page' ) ) ?>" target="_blank"></a></small>
                                </label>
                            </li>
                        </ul>
                    </div>
                    <div class="form-group">
                        <label for="woocommerce_products">
                            <input type="checkbox" name="chilisearch_wtf_settings[woocommerce_products]" id="woocommerce_products" <?= $this->wts_settings['woocommerce_products'] ? 'checked' : '' ?> <?= ! is_plugin_active( 'woocommerce/woocommerce.php' ) ? 'disabled' : '' ?>>
                            <?= __( 'wooCommerce products', 'chilisearch' ) ?> <?= ! is_plugin_active( 'woocommerce/woocommerce.php' ) ? '<small>' . __( '(wooCommerce plugin is not installed)', 'chilisearch' ) . '</small>' : '' ?>
                            <small><a href="<?= esc_url( admin_url( 'edit.php?post_status=publish&post_type=product&stock_status=instock' ) ) ?>" target="_blank"></a></small>
                        </label>
                        <ul>
                            <li>
                                <label class="mb-0" for="woocommerce_products_approved_comments">
                                    <input type="checkbox" name="chilisearch_wtf_settings[woocommerce_products_approved_comments]" id="woocommerce_products_approved_comments" <?= $this->wts_settings['woocommerce_products_approved_comments'] ? 'checked' : '' ?> disabled="disabled">
                                    <?= __( 'Approved comments', 'chilisearch' ) ?>
                                    <small><a href="<?= esc_url( admin_url( 'edit-comments.php?comment_status=approved&post_type=product' ) ) ?>" target="_blank"></a></small>
                                </label>
                            </li>
                            <li>
                                <label class="mb-0" for="woocommerce_products_sku">
                                    <input type="checkbox" name="chilisearch_wtf_settings[woocommerce_products_sku]" id="woocommerce_products_sku" <?= $this->wts_settings['woocommerce_products_sku'] ? 'checked' : '' ?> disabled="disabled">
                                    <?= __( 'Product SKU', 'chilisearch' ) ?>
                                    <small><a href="<?= esc_url( admin_url( 'edit.php?post_status=publish&post_type=product&stock_status=instock' ) ) ?>" target="_blank"></a></small>
                                </label>
                            </li>
                            <li class="mb-0">
                                <label class="mb-0" for="woocommerce_products_outofstock">
                                    <input type="checkbox" name="chilisearch_wtf_settings[woocommerce_products_outofstock]" id="woocommerce_products_outofstock" <?= $this->wts_settings['woocommerce_products_outofstock'] ? 'checked' : '' ?> disabled="disabled">
                                    <?= __( 'Out-of-stock products', 'chilisearch' ) ?>
                                    <small><a href="<?= esc_url( admin_url( 'edit.php?post_status=publish&post_type=product&stock_status=outofstock' ) ) ?>" target="_blank"></a></small>
                                </label>
                            </li>
                        </ul>
                    </div>
                    <div class="form-group">
                        <label for="bbpress_forum">
                            <input type="checkbox" name="chilisearch_wtf_settings[bbpress_forum]" id="bbpress_forum" <?= $this->wts_settings['bbpress_forum'] ? 'checked' : '' ?> <?= ! is_plugin_active( 'bbpress/bbpress.php' ) ? 'disabled' : '' ?>>
                            <?= __( 'bbPress Forums', 'chilisearch' ) ?> <?= ! is_plugin_active( 'bbpress/bbpress.php' ) ? '<small>' . __( '(bbPress plugin is not installed)', 'chilisearch' ) . '</small>' : '' ?>
                            <small><a href="<?= esc_url( admin_url( 'edit.php?post_status=publish&post_type=forum' ) ) ?>" target="_blank"></a></small>
                        </label>
                        <ul>
                            <li>
                                <label class="mb-0" for="bbpress_topic">
                                    <input type="checkbox" name="chilisearch_wtf_settings[bbpress_topic]" id="bbpress_topic" <?= $this->wts_settings['bbpress_topic'] ? 'checked' : '' ?> disabled="disabled">
                                    <?= __( 'bbPress Topics', 'chilisearch' ) ?>
                                    <small><a href="<?= esc_url( admin_url( 'edit.php?post_status=publish&post_type=topic' ) ) ?>" target="_blank"></a></small>
                                </label>
                            </li>
                            <li class="mb-0">
                                <label class="mb-0" for="bbpress_reply">
                                    <input type="checkbox" name="chilisearch_wtf_settings[bbpress_reply]" id="bbpress_reply" <?= $this->wts_settings['bbpress_reply'] ? 'checked' : '' ?> disabled="disabled">
                                    <?= __( 'bbPress Replies', 'chilisearch' ) ?>
                                    <small><a href="<?= esc_url( admin_url( 'edit.php?post_status=publish&post_type=reply' ) ) ?>" target="_blank"></a></small>
                                </label>
                            </li>
                        </ul>
                    </div>
                    <div class="form-group">
                        <label for="media">
                            <input type="checkbox" name="chilisearch_wtf_settings[media]" id="media" <?= $this->wts_settings['media'] ? 'checked' : '' ?>>
                            <?= __( 'Media', 'chilisearch' ) ?>
                            <small><a href="<?= esc_url( admin_url( 'edit.php?post_status=publish&post_type=attachment' ) ) ?>" target="_blank"></a></small>
                        </label>
                        <ul>
                            <li>
                                <label class="mb-0" for="media_doc_files">
                                    <input type="checkbox" name="chilisearch_wtf_settings[media_doc_files]" id="media_doc_files" <?= $this->wts_settings['media_doc_files'] ? 'checked' : '' ?> disabled="disabled">
                                    <?= __( 'Inside document files (doc, docx, pptx, pdf, xlsx, …)', 'chilisearch' ) ?>
                                    <small><a href="<?= esc_url( admin_url( 'upload.php?post_mime_type=application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/vnd.ms-word.document.macroEnabled.12,application/vnd.ms-word.template.macroEnabled.12,application/vnd.oasis.opendocument.text,application/vnd.apple.pages,application/pdf,application/vnd.ms-xpsdocument,application/oxps,application/rtf,application/wordperfect,application/octet-stream' ) ) ?>" target="_blank"></a></small>
                                </label>
                            </li>
                            <li class="mb-0">
                                <label class="mb-0" for="media_approved_comments">
                                    <input type="checkbox" name="chilisearch_wtf_settings[media_approved_comments]" id="media_approved_comments" <?= $this->wts_settings['media_approved_comments'] ? 'checked' : '' ?> disabled="disabled">
                                    <?= __( 'Approved comments', 'chilisearch' ) ?>
                                    <small><a href="<?= esc_url( admin_url( 'edit-comments.php?comment_status=approved&post_type=attachment' ) ) ?>" target="_blank"></a></small>
                                </label>
                            </li>
                        </ul>
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
        <span style="float: left;" id="get_post_counts_spinner" class="spinner is-active"></span>
        <?php submit_button(); ?>
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
                    jQuery('#get_post_counts_spinner').remove();
                    jQuery('label[for="posts"] small a').text(
                        "(" + wordpressPostsCount.post + ")"
                    )
                    jQuery('label[for="posts_approved_comments"] small a').text(
                        "(" + wordpressPostsCount.post_comments + ")"
                    )
                    jQuery('label[for="pages"] small a').text(
                        "(" + wordpressPostsCount.page + ")"
                    )
                    jQuery('label[for="pages_approved_comments"] small a').text(
                        "(" + wordpressPostsCount.page_comments + ")"
                    )
                    jQuery('label[for="media"] small a').text(
                        "(" + wordpressPostsCount.attachment + ")"
                    )
                    jQuery('label[for="media_doc_files"] small a').text(
                        "(" + wordpressPostsCount.attachment_docs + ")"
                    )
                    jQuery('label[for="media_approved_comments"] small a').text(
                        "(" + wordpressPostsCount.attachment_comments + ")"
                    )
                    if ('product' in wordpressPostsCount && 'product_comments' in wordpressPostsCount && 'product_outofstock' in wordpressPostsCount) {
                        jQuery('label[for="woocommerce_products"] small a').text(
                            "(" + wordpressPostsCount.product + ")"
                        )
                        jQuery('label[for="woocommerce_products_approved_comments"] small a').text(
                            "(" + wordpressPostsCount.product_comments + ")"
                        )
                        jQuery('label[for="woocommerce_products_outofstock"] small a').text(
                            "(" + wordpressPostsCount.product_outofstock + ")"
                        )
                    }
                    if ('bbpress_forum' in wordpressPostsCount && 'bbpress_topic' in wordpressPostsCount && 'bbpress_reply' in wordpressPostsCount) {
                        jQuery('label[for="bbpress_forum"] small a').text(
                            "(" + wordpressPostsCount.bbpress_forum + ")"
                        )
                        jQuery('label[for="bbpress_topic"] small a').text(
                            "(" + wordpressPostsCount.bbpress_topic + ")"
                        )
                        jQuery('label[for="bbpress_reply"] small a').text(
                            "(" + wordpressPostsCount.bbpress_reply + ")"
                        )
                    }
                    return;
                }
                alert(response.message);
            }
        );
        jQuery('#posts').change(function () {
            if (this.checked) {
                $('#posts_approved_comments').removeAttr('disabled');
            } else {
                $('#posts_approved_comments').attr('disabled', 'disabled');
            }
        });
        jQuery('#pages').change(function () {
            if (this.checked) {
                $('#pages_approved_comments').removeAttr('disabled');
            } else {
                $('#pages_approved_comments').attr('disabled', 'disabled');
            }
        });
        jQuery('#media').change(function () {
            if (this.checked) {
                $('#media_doc_files').removeAttr('disabled');
                $('#media_approved_comments').removeAttr('disabled');
            } else {
                $('#media_doc_files').attr('disabled', 'disabled');
                $('#media_approved_comments').attr('disabled', 'disabled');
            }
        });
        jQuery('#woocommerce_products').change(function () {
            if (this.checked) {
                $('#woocommerce_products_approved_comments').removeAttr('disabled');
                $('#woocommerce_products_sku').removeAttr('disabled');
                $('#woocommerce_products_outofstock').removeAttr('disabled');
            } else {
                $('#woocommerce_products_approved_comments').attr('disabled', 'disabled');
                $('#woocommerce_products_sku').attr('disabled', 'disabled');
                $('#woocommerce_products_outofstock').attr('disabled', 'disabled');
            }
        });
        jQuery('#bbpress_forum').change(function () {
            if (this.checked) {
                $('#bbpress_topic').removeAttr('disabled');
                $('#bbpress_reply').removeAttr('disabled');
            } else {
                $('#bbpress_topic').attr('disabled', 'disabled');
                $('#bbpress_reply').attr('disabled', 'disabled');
            }
        });
        jQuery('#posts').trigger('change');
        jQuery('#pages').trigger('change');
        jQuery('#media').trigger('change');
        jQuery('#woocommerce_products').trigger('change');
        jQuery('#bbpress_forum').trigger('change');
        jQuery('#site_index_config').submit(function (e) {
            e.preventDefault();
            let reindex = jQuery('#site_index_config #reindex').is(":checked")
            jQuery('#site_index_config button[type="submit"]').prop('disabled', true)
            jQuery.post(
                ajaxurl,
                {
                    'action': 'admin_ajax_index_config',
                    'posts': jQuery('#site_index_config #posts').is(":checked"),
                    'posts_approved_comments': jQuery('#site_index_config #posts_approved_comments').is(":checked"),
                    'pages': jQuery('#site_index_config #pages').is(":checked"),
                    'pages_approved_comments': jQuery('#site_index_config #pages_approved_comments').is(":checked"),
                    'media': jQuery('#site_index_config #media').is(":checked"),
                    'media_approved_comments': jQuery('#site_index_config #media_approved_comments').is(":checked"),
                    'woocommerce_products': jQuery('#site_index_config #woocommerce_products').is(":checked"),
                    'woocommerce_products_approved_comments': jQuery('#site_index_config #woocommerce_products_approved_comments').is(":checked"),
                    'woocommerce_products_sku': jQuery('#site_index_config #woocommerce_products_sku').is(":checked"),
                    'woocommerce_products_outofstock': jQuery('#site_index_config #woocommerce_products_outofstock').is(":checked"),
                    'bbpress_forum': jQuery('#site_index_config #bbpress_forum').is(":checked"),
                    'bbpress_topic': jQuery('#site_index_config #bbpress_topic').is(":checked"),
                    'bbpress_reply': jQuery('#site_index_config #bbpress_reply').is(":checked"),
                    'media_doc_files': jQuery('#site_index_config #media_doc_files').is(":checked"),
                },
                function (response) {
                    if (response.status) {
                        window.location.replace("<?= admin_url( 'admin.php?page=chilisearch&tab=indexing' . ( isset( $_GET['get-started'] ) ? '&get-started' : '' ) ) ?>" + (reindex ? '&reindex' : ''));
                        return;
                    }
                    jQuery('#site_index_config button[type="submit"]').prop('disabled', false)
                    alert(response.message);
                }
            );
            return false;
        });
        String.prototype.csf = String.prototype.csf || function () {
            let str = this.toString();
            if (arguments.length) {
                let t = typeof arguments[0],
                    args = ("string" === t || "number" === t) ? Array.prototype.slice.call(arguments) : arguments[0];
                for (let arg in args) {
                    str = str.replace(new RegExp("\\{" + arg + "\\}", "gi"), args[arg]);
                }
            }

            return str;
        };
    });
</script>
