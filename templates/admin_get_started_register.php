<style>
    #chilisearch_terms_and_conditions_holder {
        height: 400px;
        overflow-y: scroll;
        border: 1px solid #ccc;
        padding: 10px;
    }
    #chilisearch_terms_and_conditions_consent {
        margin-top: 15px;
    }
</style>
<div class="container">
	<div class="row" style="margin-top: 100px">
		<div class="col-lg-8 col-md-12 offset-lg-2">
			<div class="card" style="max-width: 100%;">
				<div class="card-header card-header-primary">
					<h4 class="card-title"><?= __('Terms and Conditions Approval', 'chilisearch') ?></h4>
				</div>
				<div class="card-body">
                    <h2>Terms and Conditions:</h2>
                    <div id="chilisearch_terms_and_conditions_holder"></div>
                    <div id="chilisearch_terms_and_conditions_consent">
                        <p>
                            <?= sprintf(__('By accepting the Terms and Conditions, you agree that your website name, url, email and language will be shared with %sChiliSearch%s.', 'chilisearch'), '<a href="https://chilisearch.com/" target="_blank">', '</a>'); ?>
                        </p>
                        <form method="post" action="" id="form_terms_and_conditions">
                            <p class="text-center">
                                <input type="hidden" name="accept_terms_and_conditions" value="1"/>
                                <button type="submit" class="btn btn-primary"><?= __('I accept Terms and Conditions', 'chilisearch') ?></button>
                            </p>
                            <div class="clearfix"></div>
                        </form>
                        <div class="clearfix"></div>
                    </div>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript" >
    jQuery(document).ready(function($) {
        jQuery('#form_terms_and_conditions button[type="submit"]').prop('disabled', true)
        jQuery.get(
            'https://chilisearch.com/wp-json/wp/v2/pages/6374',
            function(response) {
                if (response.content.rendered) {
                    jQuery('#chilisearch_terms_and_conditions_holder').html(response.content.rendered);
                    jQuery('#form_terms_and_conditions button[type="submit"]').prop('disabled', false)
                    return;
                }
                alert(response);
            }
        );
        jQuery('#form_terms_and_conditions').submit(function (e) {
            e.preventDefault();
            jQuery('#form_terms_and_conditions button[type="submit"]').prop('disabled', true)
            jQuery.post(
                ajaxurl,
                {
                    'action': 'admin_ajax_register_website',
                },
                function(response) {
                    if (response.status) {
                        window.location.replace("<?= esc_url(admin_url('admin.php?page=chilisearch')) ?>");
                        return;
                    }
                    jQuery('#form_terms_and_conditions button[type="submit"]').prop('disabled', false)
                    alert(response.message);
                }
            );
            return false;
        });
    });
</script>
