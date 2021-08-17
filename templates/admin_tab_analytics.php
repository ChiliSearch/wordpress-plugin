<?php
$siteInfo                        = ChiliSearch::getInstance()->get_website_info();
$plan                            = ChiliSearch::getInstance()->get_current_plan();
$planInfo                        = isset( $siteInfo['planInfo'] ) ? esc_html( $siteInfo['planInfo'] ) : '';
$documentsCount                  = isset( $siteInfo['documentsCount'] ) ? number_format( (int)$siteInfo['documentsCount'] ) : __( 'N/A', 'chilisearch' );
$documentCountLimit              = isset( $siteInfo['documentCountLimit'] ) ? number_format( (int)$siteInfo['documentCountLimit'] ) : __( 'N/A', 'chilisearch' );
$thisMonthRequestCount           = isset( $siteInfo['thisMonthRequestCount'] ) ? number_format( (int)$siteInfo['thisMonthRequestCount'] ) : __( 'N/A', 'chilisearch' );
$usedSpace                       = isset( $siteInfo['usedSpace'] ) ? esc_html( $siteInfo['usedSpace'] ) : __( 'N/A', 'chilisearch' );
wp_enqueue_script('chart-js', 'https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.2.0/chart.min.js' );
wp_add_inline_script( 'chart-js', "var searchPerDayChart = new Chart(document.getElementById('searchPerDayChart').getContext('2d'),{type:'line',data:{labels:['', ''],datasets:[{label:'loading ...', data: [0], borderWidth: 1}]},options:{responsive: true}});" );
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
    .analytics-holder {
        width: 33%;
        margin-right: 30px;
    }
    .is-placeholder {
        animation: loading-fade 1.6s ease-in-out infinite;
        background-color: #f0f0f0;
        color: transparent;
        display: inline-block;
        height: 16px;
        max-width: 120px;
        width: 80%;
    }
    .is-placeholder::after {
        content: '\00a0';
    }
</style>
<div class="holder card-holder">
    <div class="card card-stats">
        <div class="card-header card-header-info card-header-icon">
            <p class="card-category"><?= __( 'Number of Indexed Documents', 'chilisearch' ) ?>:</p>
            <h3 class="card-title"><?= $documentsCount ?><small>/<?= $documentCountLimit ?></small></h3>
            <a href="<?= admin_url( 'admin.php?page=chilisearch&tab=where-to-search' ) ?>"><?= __( 'Manage', 'chilisearch' ) ?> →</a>
            <a href="<?= admin_url( 'admin.php?page=chilisearch&tab=license' ) ?>" style="margin-left: 10px"><?= __( 'Want More?', 'chilisearch' ) ?> →</a>
        </div>
    </div>
    <div class="card card-stats">
        <div class="card-header card-header-info card-header-icon">
            <p class="card-category"><?= sprintf( __( 'Searches in %s', 'chilisearch' ), date( 'F' ) ) ?>:</p>
            <h3 class="card-title"><?= $thisMonthRequestCount ?></h3>
            <a href="<?= admin_url( 'admin.php?page=chilisearch&tab=license' ) ?>"><?= __( 'See Plans', 'chilisearch' ) ?> →</a>
        </div>
    </div>
    <div class="card card-stats">
        <div class="card-header card-header-info card-header-icon">
            <p class="card-category"><?= __( 'Used Space', 'chilisearch' ) ?>:</p>
            <h3 class="card-title"><?= $usedSpace ?></h3>
            <a href="<?= admin_url( 'admin.php?page=chilisearch&tab=license' ) ?>"><?= __( 'See Plans', 'chilisearch' ) ?> →</a>
        </div>
    </div>
    <div style="clear:both;"></div>
</div>

<div class="holder">
    <div class="analytics-holder">
        <h2><?= __('Last Search Queries', 'chilisearch') ?>:</h2>
        <table class="wp-list-table widefat striped table-view-list" id="lastSearchQueries">
            <thead>
            <tr>
                <th class="manage-column column-title"><?= __('Query', 'chilisearch') ?></th>
                <th class="manage-column column-date"><?= __('Date', 'chilisearch') ?></th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td><span class="is-placeholder"></span></td>
                <td><span class="is-placeholder"></span></td>
            </tr>
            <tr>
                <td><span class="is-placeholder"></span></td>
                <td><span class="is-placeholder"></span></td>
            </tr>
            <tr>
                <td><span class="is-placeholder"></span></td>
                <td><span class="is-placeholder"></span></td>
            </tr>
            <tr>
                <td><span class="is-placeholder"></span></td>
                <td><span class="is-placeholder"></span></td>
            </tr>
            <tr>
                <td><span class="is-placeholder"></span></td>
                <td><span class="is-placeholder"></span></td>
            </tr>
            <tr>
                <td><span class="is-placeholder"></span></td>
                <td><span class="is-placeholder"></span></td>
            </tr>
            <tr>
                <td><span class="is-placeholder"></span></td>
                <td><span class="is-placeholder"></span></td>
            </tr>
            <tr>
                <td><span class="is-placeholder"></span></td>
                <td><span class="is-placeholder"></span></td>
            </tr>
            <tr>
                <td><span class="is-placeholder"></span></td>
                <td><span class="is-placeholder"></span></td>
            </tr>
            <tr>
                <td><span class="is-placeholder"></span></td>
                <td><span class="is-placeholder"></span></td>
            </tr>
            </tbody>

        </table>
    </div>
    <div class="analytics-holder">
        <h2><?= __('Most Searched Queries', 'chilisearch') ?>:</h2>
        <table class="wp-list-table widefat striped table-view-list" id="mostSearchedQueries">
            <thead>
            <tr>
                <th class="manage-column column-title"><?= __('Query', 'chilisearch') ?></th>
                <th class="manage-column column-date"><?= __('Count', 'chilisearch') ?></th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td><span class="is-placeholder"></span></td>
                <td><span class="is-placeholder"></span></td>
            </tr>
            <tr>
                <td><span class="is-placeholder"></span></td>
                <td><span class="is-placeholder"></span></td>
            </tr>
            <tr>
                <td><span class="is-placeholder"></span></td>
                <td><span class="is-placeholder"></span></td>
            </tr>
            <tr>
                <td><span class="is-placeholder"></span></td>
                <td><span class="is-placeholder"></span></td>
            </tr>
            <tr>
                <td><span class="is-placeholder"></span></td>
                <td><span class="is-placeholder"></span></td>
            </tr>
            <tr>
                <td><span class="is-placeholder"></span></td>
                <td><span class="is-placeholder"></span></td>
            </tr>
            <tr>
                <td><span class="is-placeholder"></span></td>
                <td><span class="is-placeholder"></span></td>
            </tr>
            <tr>
                <td><span class="is-placeholder"></span></td>
                <td><span class="is-placeholder"></span></td>
            </tr>
            <tr>
                <td><span class="is-placeholder"></span></td>
                <td><span class="is-placeholder"></span></td>
            </tr>
            <tr>
                <td><span class="is-placeholder"></span></td>
                <td><span class="is-placeholder"></span></td>
            </tr>
            </tbody>

        </table>
    </div>
    <div class="analytics-holder">
        <h2><?= __('Search per Day', 'chilisearch') ?>:</h2>
        <canvas id="searchPerDayChart" class="widgets-holder-wrap" style="padding: 10px;"></canvas>
    </div>
    <div style="clear:both;"></div>
</div>
<script>
    function getRandomColor() {
        let color = '#';
        for (var i = 0; i < 6; i++) {
            color += '0123456789ABCDEF'[Math.floor(Math.random() * 16)];
        }
        return color;
    }
    (function() {
        jQuery.post(
            ajaxurl,
            {
                'action': 'admin_ajax_get_analytics_from_chilisearch',
            },
            function (response, status) {
                if (status === "success" && response.status) {
                    let lastSearchQueriesTable = document.querySelector('table#lastSearchQueries tbody');
                    lastSearchQueriesTable.innerHTML = ''
                    for (let lastQuery of response.analytics.lastQueries) {
                        let tr = document.createElement('tr');
                        let tdQuery = document.createElement('td');
                        let strong = document.createElement('strong');
                        strong.innerText = lastQuery.query
                        tdQuery.append(strong)
                        tr.append(tdQuery)
                        let tdDate = document.createElement('td');
                        tdDate.innerText = lastQuery.receivedAt
                        tr.append(tdDate)
                        lastSearchQueriesTable.append(tr)
                    }
                    if (response.analytics.lastQueries.length === 0) {
                        let tr = document.createElement('tr');
                        let td = document.createElement('td');
                        td.setAttribute("colspan", "2");
                        td.innerText = "- <?= __('no result', 'chilisearch') ?> -";
                        tr.append(td);
                        lastSearchQueriesTable.append(tr);
                    }

                    let mostSearchedQueriesTable = document.querySelector('table#mostSearchedQueries tbody');
                    mostSearchedQueriesTable.innerHTML = ''
                    for (let mostSearchedQuery of response.analytics.mostSearchedQueries) {
                        let tr = document.createElement('tr');
                        let tdQuery = document.createElement('td');
                        let strong = document.createElement('strong');
                        strong.innerText = mostSearchedQuery.query
                        tdQuery.append(strong)
                        tr.append(tdQuery)
                        let tdDate = document.createElement('td');
                        tdDate.innerText = mostSearchedQuery.count
                        tr.append(tdDate)
                        mostSearchedQueriesTable.append(tr)
                    }
                    if (response.analytics.mostSearchedQueries.length === 0) {
                        let tr = document.createElement('tr');
                        let td = document.createElement('td');
                        td.setAttribute("colspan", "2");
                        td.innerText = "- <?= __('no result', 'chilisearch') ?> -";
                        tr.append(td);
                        mostSearchedQueriesTable.append(tr);
                    }

                    let searchPerDayMap = {
                        sayt: {
                            label: '<?= __('Search as you Type', 'chilisearch') ?>',
                            borderColor: '#ee1e1e'
                        },
                        search: {
                            label: '<?= __('Search', 'chilisearch') ?>',
                            borderColor: '#0078c9'
                        },
                    }
                    searchPerDayChart.data.labels = response.analytics.searchPerDay.labels;
                    searchPerDayChart.data.datasets = [];
                    for (let dataset in response.analytics.searchPerDay.dataset) {
                        searchPerDayChart.data.datasets.push({
                            label: (dataset in searchPerDayMap) ? searchPerDayMap[dataset].label : dataset,
                            data: response.analytics.searchPerDay.dataset[dataset],
                            borderColor: (dataset in searchPerDayMap) ? searchPerDayMap[dataset].borderColor : getRandomColor(),
                            tension: 0.4,
                            borderWidth: 1
                        });
                    }
                    searchPerDayChart.update();
                } else {
                    console.log('Failed to get analytics from chilisearch.');
                    console.log(response);
                }
            }
        ).fail(function () {
            console.log('Failed to get analytics from chilisearch.');
        });
    })()
</script>

<a href="https://wordpress.org/support/plugin/chilisearch/reviews/?filter=5" target="_blank" style="margin-top:20px;display:block;"><?= __( 'Leave us a review', 'chilisearch' ) ?> →</a>
