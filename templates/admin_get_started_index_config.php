<div class="container">
    <div class="row" style="margin-top: 100px">
        <div class="col-lg-6 col-md-12 offset-lg-3">
            <div class="card">
                <div class="card-header card-header-primary">
                    <h4 class="card-title">Setup your indexing config</h4>
                    <p class="card-category">Index what you want to be available in search.</p>
                </div>
                <div class="card-body">
                    <form method="post" action="" id="site_index_config" class="form-check">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
									<?= sprintf(__( 'After setting up everything, we will share a copy of your PUBLIC content (posts/pages, on your choice) with SearChili to make it available in search results. You can always manage this content on %sSearChili Dashboard%s.<br>Note that only your public content will be shared with SearChili, in case you change the status of a content to non-public or remove a content, it will be removed from SearChili and search results.', 'searchili' ), '<a href="https://app.searchi.li" target="_blank">', '</a>'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="index_entities_posts">
                                        <input type="checkbox" name="index_entities_posts" id="index_entities_posts" <?= !empty($this->settings['index_entities_posts']) ? 'checked' : '' ?>>
                                        <?= __('Index public Posts', 'searchili') ?>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="index_entities_pages">
                                        <input type="checkbox" name="index_entities_pages" id="index_entities_pages" <?= !empty($this->settings['index_entities_pages']) ? 'checked' : '' ?>>
                                        <?= __('Index public Pages', 'searchili') ?>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary"><?= __('Submit', 'searchili') ?></button>
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
                    'index_entities_posts': jQuery('#site_index_config #index_entities_posts').is(":checked"),
                    'index_entities_pages': jQuery('#site_index_config #index_entities_pages').is(":checked"),
                },
                function (response) {
                    if (response.status) {
                        window.location.replace("<?= esc_url(admin_url('admin.php?page=searchili-indexing')) ?>");
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
