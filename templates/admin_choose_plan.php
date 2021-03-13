<?php
$siteInfo = $this->get_website_info(true);
$loginToken = isset($siteInfo['loginToken']) ? (string)$siteInfo['loginToken'] : '';
?>
<style>
    #chilisearch_pricing_iframe {
        height: 0;
        margin: 100px auto;
        width: 80%;
        display: block;
    }
</style>
<script type="text/javascript">
    var eventMethod = window.addEventListener ? "addEventListener" : "attachEvent";
    var eventer = window[eventMethod];
    var messageEvent = (eventMethod === "attachEvent") ? "onmessage" : "message";
    document.addEventListener("visibilitychange", function() {
        if (!document.hidden){
            document.getElementById('chilisearch_pricing_iframe').src += ''
        }
    });
    eventer(messageEvent, function (e) {
        console.log(e);
        if (e.data === "goToNextStep" || e.message === "goToNextStep") {
            window.location.replace("<?= admin_url( 'admin.php?page=chilisearch&pass_get_started_plan_finished' ) ?>");
        } else if (('key' in e.data && e.data.key === "setPageSize") || ('key' in e.message && e.message.key === "setPageSize")) {
            jQuery('#chilisearch_pricing_iframe').height(e.data.value)
        }
    });
</script>
<iframe id="chilisearch_pricing_iframe" src="<?= ChiliSearch::CHILISEARCH_APP_BASE_URI ?>wordpress/pricing?login-token=<?= $loginToken ?>"></iframe>

<a href="<?= admin_url( 'admin.php?page=chilisearch&pass_get_started_plan_finished' ) ?>" class="button"><?= __( 'Skip', 'chilisearch' ) ?> →</a>
