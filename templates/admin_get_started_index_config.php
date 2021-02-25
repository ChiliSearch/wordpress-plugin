<div class="container">
    <div class="row" style="margin-top: 100px">
        <div class="col-lg-6 col-md-12 offset-lg-3">
            <div class="card">
                <div class="card-header card-header-primary">
                    <h4 class="card-title"><?= __('Choose where to search', 'chilisearch') ?></h4>
                </div>
                <div class="card-body">
                    <form method="post" action="" id="site_index_config" class="form-check">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
									<?= sprintf(__( 'Search between:', 'chilisearch' ), '<a href="https://app.chilisearch.com" target="_blank">', '</a>'); ?>
                                </div>
                                <div class="form-group">
                                    <label class="index_documents_posts">
                                        <input type="checkbox" name="index_documents_posts" id="index_documents_posts" <?= $this->settings['index_documents_posts'] ? 'checked' : '' ?>>
                                        <?= __('Posts', 'chilisearch') ?>
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label class="index_documents_pages">
                                        <input type="checkbox" name="index_documents_pages" id="index_documents_pages" <?= $this->settings['index_documents_pages'] ? 'checked' : '' ?>>
                                        <?= __('Pages', 'chilisearch') ?>
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label class="index_documents_pages">
                                        <input type="checkbox" name="index_documents_media" id="index_documents_media" <?= $this->settings['index_documents_media'] ? 'checked' : '' ?>>
                                        <?= __('Media', 'chilisearch') ?>
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label class="index_documents_pages">
                                        <input type="checkbox" name="index_documents_woocommerce_products" id="index_documents_woocommerce_products" <?= $this->settings['index_documents_woocommerce_products'] ? 'checked' : '' ?> <?= !is_plugin_active('woocommerce/woocommerce.php') ? 'disabled' : '' ?>>
                                        <?= __('wooCommerce products', 'chilisearch') ?> <?= !is_plugin_active('woocommerce/woocommerce.php') ? '<small>' . __('(wooCommerce plugin is not installed)', 'chilisearch') . '</small>' : '' ?>
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label class="index_documents_pages">
                                        <input type="checkbox" name="index_documents_bbpress" id="index_documents_bbpress" <?= $this->settings['index_documents_bbpress'] ? 'checked' : '' ?> <?= !is_plugin_active('bbpress/bbpress.php') ? 'disabled' : '' ?>>
                                        <?= __('bbPress', 'chilisearch') ?> <?= !is_plugin_active('bbpress/bbpress.php') ? '<small>' . __('(bbPress plugin is not installed)', 'chilisearch') . '</small>' : '' ?>
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label class="index_documents_pages">
                                        <input type="checkbox" name="index_documents_approved_comments" id="index_documents_approved_comments" <?= $this->settings['index_documents_approved_comments'] ? 'checked' : '' ?>>
                                        <?= __('Approved Comments', 'chilisearch') ?>
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label class="index_documents_pages">
                                        <input type="checkbox" name="index_documents_doc_files" id="index_documents_doc_files" <?= $this->settings['index_documents_doc_files'] ? 'checked' : '' ?>>
                                        <?= __('Document Files (doc, docx, pptx, pdf, xlsx, …)', 'chilisearch') ?>
                                    </label>
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
    jQuery(document).ready(function ($) {
        jQuery('#site_index_config').submit(function (e) {
            e.preventDefault();
            jQuery('#site_index_config button[type="submit"]').prop('disabled', true)
            jQuery.post(
                ajaxurl,
                {
                    'action': 'admin_ajax_index_config',
                    'index_documents_posts': jQuery('#site_index_config #index_documents_posts').is(":checked"),
                    'index_documents_pages': jQuery('#site_index_config #index_documents_pages').is(":checked"),
                    'index_documents_media': jQuery('#site_index_config #index_documents_media').is(":checked"),
                    'index_documents_woocommerce_products': jQuery('#site_index_config #index_documents_woocommerce_products').is(":checked"),
                    'index_documents_bbpress': jQuery('#site_index_config #index_documents_bbpress').is(":checked"),
                    'index_documents_approved_comments': jQuery('#site_index_config #index_documents_approved_comments').is(":checked"),
                    'index_documents_doc_files': jQuery('#site_index_config #index_documents_doc_files').is(":checked"),
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
    });
</script>
