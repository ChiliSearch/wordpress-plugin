<?php
$siteInfo              = ChiliSearch::getInstance()->get_website_info();
$plan                  = ChiliSearch::getInstance()->get_current_plan();
$planInfo              = isset( $siteInfo['planInfo'] ) ? esc_html( $siteInfo['planInfo'] ) : '';
$documentsCount        = isset( $siteInfo['documentsCount'] ) ? esc_html( $siteInfo['documentsCount'] ) : __( 'N/A', 'chilisearch' );
$usedSpace             = isset( $siteInfo['usedSpace'] ) ? esc_html( $siteInfo['usedSpace'] ) : __( 'N/A', 'chilisearch' );
$thisMonthRequestCount = isset( $siteInfo['thisMonthRequestCount'] ) ? esc_html( $siteInfo['thisMonthRequestCount'] ) : __( 'N/A', 'chilisearch' );
?>
<div class="card card-stats">
    <div class="card-header card-header-info card-header-icon">
        <p class="card-category"><?= __( 'Plan', 'chilisearch' ) ?>:</p>
        <h3 class="card-title"><?= ucfirst($plan) ?><?= !empty($planInfo) ? " <small style='font-weight: normal'>$planInfo</small>" : '' ?></h3>
        <a href="<?= admin_url( 'admin.php?page=chilisearch&tab=plans' ) ?>"><?= __( 'See Plans', 'chilisearch' ) ?> →</a>
        <?php if ($plan === 'premium'): ?>
            <a href="https://app.chilisearch.com/websites" target="_blank" style="margin:0 10px;"><?= __( 'Manage', 'chilisearch' ) ?> →</a>
        <?php endif; ?>
    </div>
</div>
<div class="card card-stats">
    <div class="card-header card-header-info card-header-icon">
        <p class="card-category"><?= __( 'Number of Indexed Documents', 'chilisearch' ) ?>:</p>
        <h3 class="card-title"><?= $documentsCount ?></h3>
    </div>
</div>
<div class="card card-stats">
    <div class="card-header card-header-success card-header-icon">
        <p class="card-category">
            <?= sprintf( __( 'Number of Searches since first of %s', 'chilisearch' ), date( 'F' ) ) ?>
            <small><?= __( '(updates every 10 minutes)', 'chilisearch' ) ?></small>:
        </p>
        <h3 class="card-title"><?= $thisMonthRequestCount ?></h3>
    </div>
</div>
<div class="card card-stats">
    <div class="card-header card-header-warning card-header-icon">
        <p class="card-category"><?= __( 'Used Space', 'chilisearch' ) ?>
            <small><?= __( '(updates every 10 minutes)', 'chilisearch' ) ?></small>:</p>
        <h3 class="card-title"><?= $usedSpace ?></h3>
    </div>
</div>
<a href="https://wordpress.org/support/plugin/chilisearch/reviews/?filter=5" target="_blank" style="margin-top:20px;display:block;"><?= __('Leave us a review', 'chilisearch') ?> →</a>