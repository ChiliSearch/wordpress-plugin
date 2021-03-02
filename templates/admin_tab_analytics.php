<?php
$siteInfo = ChiliSearch::getInstance()->get_website_info();
$documentsCount = isset($siteInfo['documentsCount']) ? esc_html($siteInfo['documentsCount']) : __('N/A', 'chilisearch');
$usedSpace = isset($siteInfo['usedSpace']) ? esc_html($siteInfo['usedSpace']) : __('N/A', 'chilisearch');
$thisMonthRequestCount = isset($siteInfo['thisMonthRequestCount']) ? esc_html($siteInfo['thisMonthRequestCount']) : __('N/A', 'chilisearch');
?>
<?php if (isset($_GET['get-started'])): ?>
<div class="notice notice-success is-dismissible" style="margin-top: 20px;">
    <p><strong><?= sprintf( __('%s documents are indexed and ready to be searched. Visit your website and try out the power of search!', 'chilisearch'), $documentsCount ) ?></strong></p>
</div>
<?php endif ?>
<div class="card card-stats">
    <div class="card-header card-header-info card-header-icon">
        <p class="card-category"><?= __('Number of Indexed Documents', 'chilisearch') ?></p>
        <h3 class="card-title"><?= $documentsCount ?></h3>
    </div>
</div>
<div class="card card-stats">
    <div class="card-header card-header-success card-header-icon">
        <p class="card-category">
            <?= sprintf(__('Number of Searches since first of %s', 'chilisearch'), date( 'F' )) ?>
            <small><?= __('(updates every 10 minutes)', 'chilisearch') ?></small>
        </p>
        <h3 class="card-title"><?= $thisMonthRequestCount ?></h3>
    </div>
</div>
<div class="card card-stats">
    <div class="card-header card-header-warning card-header-icon">
        <p class="card-category"><?= __('Used Space', 'chilisearch') ?> <small><?= __('(updates every 10 minutes)', 'chilisearch') ?></small></p>
        <h3 class="card-title"><?= $usedSpace ?></h3>
    </div>
</div>