<?php
$siteInfo                        = ChiliSearch::getInstance()->get_website_info();
$plan                            = ChiliSearch::getInstance()->get_current_plan();
$planInfo                        = isset( $siteInfo['planInfo'] ) ? esc_html( $siteInfo['planInfo'] ) : '';
$referralGiftCodeCode            = isset( $siteInfo['referralGiftCode']->code ) ? esc_html( $siteInfo['referralGiftCode']->code ) : __( 'N/A', 'chilisearch' );
$referralGiftCodeAddDays         = isset( $siteInfo['referralGiftCode']->addDays ) ? esc_html( $siteInfo['referralGiftCode']->addDays ) : __( 'N/A', 'chilisearch' );
$referralGiftCodeReferrerAddDays = isset( $siteInfo['referralGiftCode']->referrerAddDays ) ? esc_html( $siteInfo['referralGiftCode']->referrerAddDays ) : __( 'N/A', 'chilisearch' );
$loginToken                      = isset( $siteInfo['loginToken'] ) ? (string) $siteInfo['loginToken'] : '';
?>
<style>
    .card-holder {
        margin-top: 30px;
        margin-bottom: 30px;
    }
    .card {
        width: 33%;
        margin-right: 30px;
    }
    .holder {
        display: flex;
        margin: 10px 2px 0 20px;
    }
    #gift-code-holder {
        margin-top: 10px;
        display: flex;
    }
    #gift-code-holder input {
        flex-grow: 1;
    }
    #gift-code-holder button {
        margin: 0 5px;
    }
</style>
<div class="holder card-holder">
    <div class="card card-stats">
        <div class="card-header card-header-info card-header-icon">
            <p class="card-category"><?= __( 'Plan', 'chilisearch' ) ?>:</p>
            <h3 class="card-title"><?= ucfirst( $plan ) ?><?= ! empty( $planInfo ) ? " <small style='font-weight: normal'>$planInfo</small>" : '' ?></h3>
            <?php if ( empty( $siteInfo['usedTrialBefore'] ) && $plan === 'basic' ): ?>
                <a href="javascript:;" onclick="jQuery('#gift-code-holder input').val('trial');jQuery('#gift-code-holder').submit()" style="margin-left: 10px"><?= __( 'Start 7-Days Trial', 'chilisearch' ) ?> →</a>
            <?php endif; ?>
        </div>
    </div>
    <div class="card card-stats">
        <div class="card-header card-header-warning card-header-icon">
            <p class="card-category">
                <label><?= __( 'Your Gift-Code:', 'chilisearch' ) ?>
                    <input onClick="this.select();" type="text" value="<?= $referralGiftCodeCode ?>" style="margin-left:3px;border:0!important;box-shadow:none;background-color:transparent;text-transform:uppercase;" readonly>
                </label>
            </p>
            <p class="card-body">
                <?php if ( $referralGiftCodeAddDays == $referralGiftCodeReferrerAddDays ): ?>
                    <?= sprintf( __( 'Invite your friends to Chili Search to win %s days Premium each, right after they redeem this gift codes.', 'chilisearch' ), $referralGiftCodeReferrerAddDays ) ?>
                <?php else: ?>
                    <?= sprintf( __( 'Invite your friends to Chili Search to win %s days Premium for them and %s days for you, right after they redeem this gift codes.', 'chilisearch' ), $referralGiftCodeAddDays, $referralGiftCodeReferrerAddDays ) ?>
                <?php endif; ?>
            </p>
        </div>
    </div>
    <div class="card card-stats">
        <div class="card-header card-header-info card-header-icon">
            <p class="card-category">
                <label for="gift-code-input"><?= __( 'Redeem Promotion Code', 'chilisearch' ) ?>:</label>
            </p>
            <form style="margin-top: 10px;" id="gift-code-holder"
                  action="<?= admin_url( 'admin.php?page=chilisearch&tab=license' ) ?>" method="post">
                <input type="text" name="gift-code" id="gift-code-input"
                       placeholder="<?= __( 'Enter Your Promotion Code …', 'chilisearch' ) ?>">
                <button type="submit" class="button button-primary"><?= __( 'Submit', 'chilisearch' ) ?></button>
            </form>
        </div>
    </div>
    <div style="clear:both;"></div>
</div>
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
    document.addEventListener("visibilitychange", function () {
        if (!document.hidden) {
            document.getElementById('chilisearch_pricing_iframe').src += ''
        }
    });
    eventer(messageEvent, function (e) {
        if (e.data === "goToNextStep" || e.message === "goToNextStep") {
            window.location.replace("<?= admin_url( 'admin.php?page=chilisearch' ) ?>");
        } else if (('key' in e.data && e.data.key === "setPageSize") || ('key' in e.message && e.message.key === "setPageSize")) {
            jQuery('#chilisearch_pricing_iframe').height(e.data.value)
        }
    });
</script>
<iframe id="chilisearch_pricing_iframe" src="<?= ChiliSearch::CHILISEARCH_APP_BASE_URI ?>wordpress/pricing?login-token=<?= $loginToken ?>"></iframe>
