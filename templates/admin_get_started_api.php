<div class="container">
	<div class="row" style="margin-top: 100px">
		<div class="col-lg-6 col-md-12 offset-lg-3">
			<div class="card">
				<div class="card-header card-header-primary">
					<h4 class="card-title">Enter your API key and API Secret</h4>
					<p class="card-category">API Key and API Secret is used for authentication between your website and SearChili.</p>
				</div>
				<div class="card-body">
                    <form method="post" action="" id="site_api_credential">
	                    <?= sprintf(_x('For getting Site API Key and API Secret, you should register your website at <a href="%s" target="_blank">SearChili (click here)</a>.', 'searchili'), 'https://app.searchi.li/auth/signup?__returnUrl=/websites/create'); ?>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="bmd-label-floating" for="site_api_key">API Key</label>
                                    <input type="text" class="form-control" name="site_api_key" id="site_api_key" value="<?= !empty($this->settings['site_api_key']) ? esc_html($this->settings['site_api_key']) : '' ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="bmd-label-floating" for="site_api_secret">API Secret</label>
                                    <input type="password" class="form-control" name="site_api_secret" id="site_api_secret" value="<?= !empty($this->settings['site_api_secret']) ? esc_html($this->settings['site_api_secret']) : '' ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="terms">
                                        <input type="checkbox" name="terms" id="terms" checked>
                                        I read <a href="https://searchi.li/terms">Terms of Use</a> and I agree them.
                                    </label>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
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
                alert('Terms of Use is not checked!')
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
                        window.location.replace("<?= esc_url(admin_url('admin.php?page=searchili')) ?>");
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
