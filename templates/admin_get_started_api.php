<div class="container">
	<div class="row" style="margin-top: 100px">
		<div class="col-lg-6 col-md-12 offset-lg-3">
			<div class="card">
				<div class="card-header card-header-primary">
					<h4 class="card-title"><?= __('Enter your API key and API Secret', 'chilisearch') ?></h4>
					<p class="card-category"><?= __('API Key and API Secret is used for authentication between your website and Chili Search.', 'chilisearch') ?></p>
				</div>
				<div class="card-body">
                    <form method="post" action="" id="site_api_credential">
	                    <?= sprintf(__('For getting Site API Key and API Secret, you should register your website at %sChili Search (click here)%s.', 'chilisearch'), '<a href="https://app.chilisearch.com/auth/signup?__returnUrl=/websites/create" target="_blank">', '</a>'); ?>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="bmd-label-floating" for="site_api_key"><?= __('API Key', 'chilisearch') ?></label>
                                    <input type="text" class="form-control" name="site_api_key" id="site_api_key" value="<?= !empty($this->settings['site_api_key']) ? esc_html($this->settings['site_api_key']) : '' ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="bmd-label-floating" for="site_api_secret"><?= __('API Secret', 'chilisearch') ?></label>
                                    <input type="password" class="form-control" name="site_api_secret" id="site_api_secret" value="<?= !empty($this->settings['site_api_secret']) ? esc_html($this->settings['site_api_secret']) : '' ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="terms">
                                        <input type="checkbox" name="terms" id="terms" checked>
                                        <?= sprintf(__('I accept %sTerms of Service%s.', 'chilisearch'), '<a href="https://chilisearch.com/policies/terms">', '</a>') ?>
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
<script type="text/javascript" >
    jQuery(document).ready(function($) {
        jQuery('#site_api_credential').submit(function (e) {
            e.preventDefault();
            if (!jQuery('#site_api_credential #terms').is(":checked")) {
                alert('<?= __('Terms of Service is not checked!', 'chilisearch') ?>')
                return false;
            }
            jQuery('#site_api_credential button[type="submit"]').prop('disabled', true)
            jQuery.post(
                ajaxurl,
                {
                    'action': 'admin_ajax_check_save_api_credentials',
                    'api_secret': jQuery('#site_api_credential #site_api_secret').val()
                },
                function(response) {
                    if (response.status) {
                        window.location.replace("<?= esc_url(admin_url('admin.php?page=chilisearch')) ?>");
                        return;
                    }
                    jQuery('#site_api_credential button[type="submit"]').prop('disabled', false)
                    alert(response.message);
                }
            );
            return false;
        });
    });
</script>
