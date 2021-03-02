<?php
$siteInfo = ChiliSearch::getInstance()->get_website_info();
?>
<div class="card card-stats">
    <div class="card-header card-header-warning card-header-icon">
        <p class="card-category"><?= __('Used Space', 'chilisearch') ?></p>
        <h3 class="card-title"><?= isset($siteInfo['usedSpace']) ? esc_html($siteInfo['usedSpace']) : __('N/A', 'chilisearch') ?></h3>
    </div>
    <div class="card-footer">
        <div class="stats">
            <a href="https://chilisearch.com" target="_blank"><?= __('Get More Details', 'chilisearch') ?></a>
        </div>
    </div>
</div>
<div class="card card-stats">
    <div class="card-header card-header-success card-header-icon">
        <p class="card-category"><?= __('Number of Searches', 'chilisearch') ?></p>
        <h3 class="card-title"><?= isset($siteInfo['thisMonthRequestCount']) ? esc_html($siteInfo['thisMonthRequestCount']) : __('N/A', 'chilisearch') ?></h3>
    </div>
    <div class="card-footer">
        <div class="stats">
            <?= sprintf(__('Since first of %s', 'chilisearch'), date( 'F' )) ?>
        </div>
    </div>
</div>
<div class="card card-stats">
    <div class="card-header card-header-info card-header-icon">
        <p class="card-category"><?= __('Number of Indexed Posts', 'chilisearch') ?></p>
        <h3 class="card-title"><?= isset($siteInfo['thisMonthRequestCount']) ? esc_html($siteInfo['thisMonthRequestCount']) : __('N/A', 'chilisearch') ?></h3>
    </div>
    <div class="card-footer">
        <div class="stats">
            <a href="https://chilisearch.com" target="_blank"><?= __('Get More Details', 'chilisearch') ?></a>
        </div>
    </div>
</div>
<div class="card">
    <h4 class="card-title"><?= __('Top searched terms', 'chilisearch') ?></h4>
    <p class="card-category"><?= __('Most searched terms.', 'chilisearch') ?></p>
    <div style="position: relative;">
        <table class="table table-hover">
            <thead><th>ID</th><th>Term</th><th>Count</th></thead>
            <tbody>
                <tr><td>1</td><td>Lorem ipsum</td><td>36,738</td></tr>
                <tr><td>2</td><td>dolor</td><td>23,789</td></tr>
                <tr><td>3</td><td>sit amet</td><td>16,142</td></tr>
                <tr><td>4</td><td>consectetur</td><td>8,735</td></tr>
                <tr><td>5</td><td>adipiscing</td><td>5,256</td></tr>
            </tbody>
        </table>
        <div id="blur-overlay" style="background-color: rgba(255,255,255, 0.7);color: #000;font-size: 21px;position: absolute;top: 0;left: 0;z-index: 7;width: 100%;height: 100%;text-align: center;line-height: 20px;"><?= __('coming soon!', 'chilisearch') ?></div>
    </div>
</div>