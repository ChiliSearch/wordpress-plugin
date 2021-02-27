<style>
    .form-group>ul {
        padding: 0 40px;
        margin: 0;
    }
</style>
<div class="container">
    <div class="row" style="margin-top: 100px">
        <div class="col-lg-8 col-md-12 offset-lg-2">
            <div class="card" style="max-width: 100%;">
                <div class="card-header card-header-primary">
                    <h4 class="card-title"><?= __('Choose where to search', 'chilisearch') ?></h4>
                </div>
                <div class="card-body">
                    <form method="post" action="" id="site_index_config" class="form-check">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
									<?= __( 'Search between:', 'chilisearch' ); ?>
                                    <span id="get_post_counts_spinner" class="spinner is-active"></span>
                                </div>
                                <div class="form-group">
                                    <label for="index_documents_posts">
                                        <input type="checkbox" name="index_documents_posts" id="index_documents_posts" <?= $this->settings['index_documents_posts'] ? 'checked' : '' ?>>
                                        <?= __('Posts', 'chilisearch') ?>
                                        <small><a href="<?= esc_url(admin_url('edit.php?post_status=publish&post_type=post')) ?>" target="_blank"></a></small>
                                    </label>
                                    <ul>
                                        <li class="mb-0">
                                            <label class="mb-0" for="index_documents_posts_approved_comments">
                                                <input type="checkbox" name="index_documents_posts_approved_comments" id="index_documents_posts_approved_comments" <?= $this->settings['index_documents_posts_approved_comments'] ? 'checked' : '' ?> disabled="disabled">
                                                <?= __('Approved comments', 'chilisearch') ?>
                                                <small><a href="<?= esc_url(admin_url('edit-comments.php?comment_status=approved&post_type=post')) ?>"></a></small>
                                            </label>
                                        </li>
                                    </ul>
                                </div>
                                <div class="form-group">
                                    <label for="index_documents_pages">
                                        <input type="checkbox" name="index_documents_pages" id="index_documents_pages" <?= $this->settings['index_documents_pages'] ? 'checked' : '' ?>>
                                        <?= __('Pages', 'chilisearch') ?>
                                        <small><a href="<?= esc_url(admin_url('edit.php?post_status=publish&post_type=page')) ?>" target="_blank"></a></small>
                                    </label>
                                    <ul>
                                        <li class="mb-0">
                                            <label class="mb-0" for="index_documents_pages_approved_comments">
                                                <input type="checkbox" name="index_documents_pages_approved_comments" id="index_documents_pages_approved_comments" <?= $this->settings['index_documents_pages_approved_comments'] ? 'checked' : '' ?> disabled="disabled">
                                                <?= __('Approved comments', 'chilisearch') ?>
                                                <small><a href="<?= esc_url(admin_url('edit-comments.php?comment_status=approved&post_type=page')) ?>"></a></small>
                                            </label>
                                        </li>
                                    </ul>
                                </div>
                                <div class="form-group">
                                    <label for="index_documents_media">
                                        <input type="checkbox" name="index_documents_media" id="index_documents_media" <?= $this->settings['index_documents_media'] ? 'checked' : '' ?>>
                                        <?= __('Media', 'chilisearch') ?>
                                        <small><a href="<?= esc_url(admin_url('edit.php?post_status=publish&post_type=attachment')) ?>" target="_blank"></a></small>
                                    </label>
                                    <ul>
                                        <li>
                                            <label class="mb-0" for="index_documents_media_doc_files">
                                                <input type="checkbox" name="index_documents_media_doc_files" id="index_documents_media_doc_files" <?= $this->settings['index_documents_media_doc_files'] ? 'checked' : '' ?> disabled="disabled">
                                                <?= __('Inside document files (doc, docx, pptx, pdf, xlsx, …)', 'chilisearch') ?>
                                                <small><a href="<?= esc_url(admin_url('upload.php?post_mime_type=application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/vnd.ms-word.document.macroEnabled.12,application/vnd.ms-word.template.macroEnabled.12,application/vnd.oasis.opendocument.text,application/vnd.apple.pages,application/pdf,application/vnd.ms-xpsdocument,application/oxps,application/rtf,application/wordperfect,application/octet-stream')) ?>" target="_blank"></a></small>
                                            </label>
                                        </li>
                                        <li class="mb-0">
                                            <label class="mb-0" for="index_documents_media_approved_comments">
                                                <input type="checkbox" name="index_documents_media_approved_comments" id="index_documents_media_approved_comments" <?= $this->settings['index_documents_media_approved_comments'] ? 'checked' : '' ?> disabled="disabled">
                                                <?= __('Approved comments', 'chilisearch') ?>
                                                <small><a href="<?= esc_url(admin_url('edit-comments.php?comment_status=approved&post_type=attachment')) ?>" target="_blank"></a></small>
                                            </label>
                                        </li>
                                    </ul>
                                </div>
                                <div class="form-group">
                                    <label for="index_documents_woocommerce_products">
                                        <input type="checkbox" name="index_documents_woocommerce_products" id="index_documents_woocommerce_products" <?= $this->settings['index_documents_woocommerce_products'] ? 'checked' : '' ?> <?= !is_plugin_active('woocommerce/woocommerce.php') ? 'disabled' : '' ?>>
                                        <?= __('wooCommerce products', 'chilisearch') ?> <?= !is_plugin_active('woocommerce/woocommerce.php') ? '<small>' . __('(wooCommerce plugin is not installed)', 'chilisearch') . '</small>' : '' ?>
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label for="index_documents_bbpress_forum">
                                        <input type="checkbox" name="index_documents_bbpress_forum" id="index_documents_bbpress_forum" <?= $this->settings['index_documents_bbpress_forum'] ? 'checked' : '' ?> <?= !is_plugin_active('bbpress/bbpress.php') ? 'disabled' : '' ?>>
                                        <?= __('bbPress Forums', 'chilisearch') ?> <?= !is_plugin_active('bbpress/bbpress.php') ? '<small>' . __('(bbPress plugin is not installed)', 'chilisearch') . '</small>' : '' ?>
                                        <small><a href="<?= esc_url(admin_url('edit.php?post_status=publish&post_type=forum')) ?>"></a></small>
                                    </label>
                                    <ul>
                                        <li>
                                            <label class="mb-0" for="index_documents_bbpress_topic">
                                                <input type="checkbox" name="index_documents_bbpress_topic" id="index_documents_bbpress_topic" <?= $this->settings['index_documents_bbpress_topic'] ? 'checked' : '' ?> disabled="disabled">
                                                <?= __('bbPress Topics', 'chilisearch') ?>
                                                <small><a href="<?= esc_url(admin_url('edit.php?post_status=publish&post_type=topic')) ?>"></a></small>
                                            </label>
                                        </li>
                                        <li class="mb-0">
                                            <label class="mb-0" for="index_documents_bbpress_reply">
                                                <input type="checkbox" name="index_documents_bbpress_reply" id="index_documents_bbpress_reply" <?= $this->settings['index_documents_bbpress_reply'] ? 'checked' : '' ?> disabled="disabled">
                                                <?= __('bbPress Replies', 'chilisearch') ?>
                                                <small><a href="<?= esc_url(admin_url('edit.php?post_status=publish&post_type=reply')) ?>"></a></small>
                                            </label>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary"><?= __('Submit', 'chilisearch') ?></button>
                        <div class="clearfix"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
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
                    jQuery('label[for="index_documents_posts"] small a').text(
                        "(" + (wordpressPostsCount.post === 1 ? "<?= __('1 Post', 'chilisearch') ?>" : "{count} {entity}".ChiliSearchFormat({count: wordpressPostsCount.post, entity: "<?= __('Posts', 'chilisearch') ?>"})) + ")"
                    )
                    jQuery('label[for="index_documents_posts_approved_comments"] small a').text(
                        "(" + (wordpressPostsCount.post_comments === 1 ? "<?= __('1 Comment', 'chilisearch') ?>" : "{count} {entity}".ChiliSearchFormat({count: wordpressPostsCount.post_comments, entity: "<?= __('Comments', 'chilisearch') ?>"})) + ")"
                    )
                    jQuery('label[for="index_documents_pages"] small a').text(
                        "(" + (wordpressPostsCount.page === 1 ? "<?= __('1 Post', 'chilisearch') ?>" : "{count} {entity}".ChiliSearchFormat({count: wordpressPostsCount.page, entity: "<?= __('Pages', 'chilisearch') ?>"})) + ")"
                    )
                    jQuery('label[for="index_documents_pages_approved_comments"] small a').text(
                        "(" + (wordpressPostsCount.page_comments === 1 ? "<?= __('1 Comment', 'chilisearch') ?>" : "{count} {entity}".ChiliSearchFormat({count: wordpressPostsCount.page_comments, entity: "<?= __('Comments', 'chilisearch') ?>"})) + ")"
                    )
                    jQuery('label[for="index_documents_media"] small a').text(
                        "(" + (wordpressPostsCount.attachment === 1 ? "<?= __('1 Media', 'chilisearch') ?>" : "{count} {entity}".ChiliSearchFormat({count: wordpressPostsCount.attachment, entity: "<?= __('Media', 'chilisearch') ?>"})) + ")"
                    )
                    jQuery('label[for="index_documents_media_doc_files"] small a').text(
                        "(" + (wordpressPostsCount.attachment_docs === 1 ? "<?= __('1 Documents', 'chilisearch') ?>" : "{count} {entity}".ChiliSearchFormat({count: wordpressPostsCount.attachment_docs, entity: "<?= __('Documents', 'chilisearch') ?>"})) + ")"
                    )
                    jQuery('label[for="index_documents_media_approved_comments"] small a').text(
                        "(" + (wordpressPostsCount.attachment_comments === 1 ? "<?= __('1 Comment', 'chilisearch') ?>" : "{count} {entity}".ChiliSearchFormat({count: wordpressPostsCount.attachment_comments, entity: "<?= __('Comments', 'chilisearch') ?>"})) + ")"
                    )
                    if ('forum' in wordpressPostsCount && 'topic' in wordpressPostsCount && 'reply' in wordpressPostsCount) {
                        jQuery('label[for="index_documents_bbpress_forum"] small a').text(
                            "(" + (wordpressPostsCount.forum === 1 ? "<?= __('1 Forum', 'chilisearch') ?>" : "{count} {entity}".ChiliSearchFormat({count: wordpressPostsCount.forum, entity: "<?= __('Forums', 'chilisearch') ?>"})) + ")"
                        )
                        jQuery('label[for="index_documents_bbpress_topic"] small a').text(
                            "(" + (wordpressPostsCount.topic === 1 ? "<?= __('1 Topic', 'chilisearch') ?>" : "{count} {entity}".ChiliSearchFormat({count: wordpressPostsCount.topic, entity: "<?= __('Topics', 'chilisearch') ?>"})) + ")"
                        )
                        jQuery('label[for="index_documents_bbpress_reply"] small a').text(
                            "(" + (wordpressPostsCount.reply === 1 ? "<?= __('1 Reply', 'chilisearch') ?>" : "{count} {entity}".ChiliSearchFormat({count: wordpressPostsCount.reply, entity: "<?= __('Replies', 'chilisearch') ?>"})) + ")"
                        )
                    }
                    return;
                }
                alert(response.message);
            }
        );
        jQuery('#index_documents_posts').change(function () {
            if (this.checked) {
                $('#index_documents_posts_approved_comments').removeAttr('disabled');
            } else {
                $('#index_documents_posts_approved_comments').attr('disabled', 'disabled');
            }
        });
        jQuery('#index_documents_pages').change(function () {
            if (this.checked) {
                $('#index_documents_pages_approved_comments').removeAttr('disabled');
            } else {
                $('#index_documents_pages_approved_comments').attr('disabled', 'disabled');
            }
        });
        jQuery('#index_documents_media').change(function () {
            if (this.checked) {
                $('#index_documents_media_doc_files').removeAttr('disabled');
                $('#index_documents_media_approved_comments').removeAttr('disabled');
            } else {
                $('#index_documents_media_doc_files').attr('disabled', 'disabled');
                $('#index_documents_media_approved_comments').attr('disabled', 'disabled');
            }
        });
        jQuery('#index_documents_bbpress_forum').change(function () {
            if (this.checked) {
                $('#index_documents_bbpress_topic').removeAttr('disabled');
                $('#index_documents_bbpress_reply').removeAttr('disabled');
            } else {
                $('#index_documents_bbpress_topic').attr('disabled', 'disabled');
                $('#index_documents_bbpress_reply').attr('disabled', 'disabled');
            }
        });
        jQuery('#index_documents_posts').trigger('change');
        jQuery('#index_documents_pages').trigger('change');
        jQuery('#index_documents_media').trigger('change');
        jQuery('#index_documents_bbpress_forum').trigger('change');
        jQuery('#site_index_config').submit(function (e) {
            e.preventDefault();
            jQuery('#site_index_config button[type="submit"]').prop('disabled', true)
            jQuery.post(
                ajaxurl,
                {
                    'action': 'admin_ajax_index_config',
                    'index_documents_posts': jQuery('#site_index_config #index_documents_posts').is(":checked"),
                    'index_documents_posts_approved_comments': jQuery('#site_index_config #index_documents_posts_approved_comments').is(":checked"),
                    'index_documents_pages': jQuery('#site_index_config #index_documents_pages').is(":checked"),
                    'index_documents_pages_approved_comments': jQuery('#site_index_config #index_documents_pages_approved_comments').is(":checked"),
                    'index_documents_media': jQuery('#site_index_config #index_documents_media').is(":checked"),
                    'index_documents_media_approved_comments': jQuery('#site_index_config #index_documents_media_approved_comments').is(":checked"),
                    'index_documents_woocommerce_products': jQuery('#site_index_config #index_documents_woocommerce_products').is(":checked"),
                    'index_documents_bbpress_forum': jQuery('#site_index_config #index_documents_bbpress_forum').is(":checked"),
                    'index_documents_bbpress_topic': jQuery('#site_index_config #index_documents_bbpress_topic').is(":checked"),
                    'index_documents_bbpress_reply': jQuery('#site_index_config #index_documents_bbpress_reply').is(":checked"),
                    'index_documents_media_doc_files': jQuery('#site_index_config #index_documents_media_doc_files').is(":checked"),
                },
                function (response) {
                    if (response.status) {
                        window.location.replace("<?= esc_url(admin_url('admin.php?page=chilisearch-indexing')) ?>");
                        return;
                    }
                    jQuery('#site_index_config button[type="submit"]').prop('disabled', false)
                    alert(response.message);
                }
            );
            return false;
        });
        String.prototype.ChiliSearchFormat = String.prototype.ChiliSearchFormat || function () {
            let str = this.toString();
            if (arguments.length) {
                let t = typeof arguments[0], args = ("string" === t || "number" === t) ? Array.prototype.slice.call(arguments) : arguments[0];
                for (let arg in args) {
                    str = str.replace(new RegExp("\\{" + arg + "\\}", "gi"), args[arg]);
                }
            };
            return str;
        };
    });
</script>
