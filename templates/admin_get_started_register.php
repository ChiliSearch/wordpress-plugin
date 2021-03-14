<style>
    #chilisearch_terms_and_conditions_holder {
        height: 600px;
        border: 1px solid #ccc;
        padding: 10px;
        margin: 0 auto;
        width: 80%;
        display: block;
        background: #fff;
    }
    #chilisearch_terms_and_conditions_consent {
        margin-top: 15px;
        text-align: center;
    }
</style>
<h1>Terms and Conditions:</h1>
<iframe id="chilisearch_terms_and_conditions_holder" src="<?= ChiliSearch::CHILISEARCH_APP_BASE_URI ?>wordpress/terms"></iframe>
<div id="chilisearch_terms_and_conditions_consent">
    <p>
        <?= sprintf( __( 'By accepting the Terms and Conditions, you agree that your website name, url, email and language will be shared with %sChili Search%s.', 'chilisearch' ), '<a href="https://chilisearch.com/" target="_blank">', '</a>' ); ?>
    </p>
    <form method="post" action="" id="form_terms_and_conditions">
        <p class="text-center">
            <input type="hidden" name="accept_terms_and_conditions" value="1"/>
            <button type="submit" class="button button-primary"><?= __( 'I accept Terms and Conditions', 'chilisearch' ) ?></button>
        </p>
        <div class="clearfix"></div>
    </form>
    <div class="clearfix"></div>
</div>
<script type="text/javascript">
    jQuery(document).ready(function ($) {
        jQuery('#form_terms_and_conditions button[type="submit"]').prop('disabled', true)
        jQuery('#chilisearch_terms_and_conditions_holder').load(function () {
            jQuery('#form_terms_and_conditions button[type="submit"]').prop('disabled', false)
        });
        jQuery('#form_terms_and_conditions').submit(function (e) {
            e.preventDefault();
            jQuery('#form_terms_and_conditions button[type="submit"]').prop('disabled', true)
            jQuery.post(
                ajaxurl,
                {
                    'action': 'admin_ajax_register_website',
                },
                function (response) {
                    if (response.status) {
                        window.location.replace("<?= admin_url( 'admin.php?page=chilisearch&tab=where-to-search&get-started' ) ?>");
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
