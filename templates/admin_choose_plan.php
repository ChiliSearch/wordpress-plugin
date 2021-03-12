<?php
$siteInfo = $this->get_website_info(true);
$loginToken = isset($siteInfo['loginToken']) ? (string)$siteInfo['loginToken'] : '';
?>
<style>
    #chilisearch_pricing_iframe {
        height: 600px;
        margin: 100px auto;
        width: 80%;
        display: block;
    }
</style>
<script>
    document.addEventListener("visibilitychange", function() {
        if (!document.hidden){
            document.getElementById('chilisearch_pricing_iframe').src += ''
        }
    });
    function goToNextStep()
    {
        window.location.replace("<?= admin_url( 'admin.php?page=chilisearch&pass_get_started_plan_finished' ) ?>");
        return;
    }
</script>
<script type="text/javascript">
    var eventMethod = window.addEventListener ? "addEventListener" : "attachEvent";
    var eventer = window[eventMethod];
    var messageEvent = (eventMethod === "attachEvent") ? "onmessage" : "message";

    eventer(messageEvent, function (e) {
        console.log(e);
        if (e.data === "goToNextStep" || e.message === "goToNextStep") {
            goToNextStep()
        } else if (('key' in e.data && e.data.key === "setPageSize") || ('key' in e.message && e.message.key === "setPageSize")) {
            jQuery('#chilisearch_pricing_iframe').height(e.data.value)
        }
    });
</script>
<iframe id="chilisearch_pricing_iframe" src="<?= ChiliSearch::CHILISEARCH_APP_BASE_URI ?>wordpress/pricing?login-token=<?= $loginToken ?>"></iframe>