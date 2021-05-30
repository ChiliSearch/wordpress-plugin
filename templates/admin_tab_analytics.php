<?php
$siteInfo                                   = ChiliSearch::getInstance()->get_website_info();
$plan                                       = ChiliSearch::getInstance()->get_current_plan();
$planInfo                                   = isset( $siteInfo['planInfo'] ) ? esc_html( $siteInfo['planInfo'] ) : '';
$documentsCount                             = isset( $siteInfo['documentsCount'] ) ? esc_html( $siteInfo['documentsCount'] ) : __( 'N/A', 'chilisearch' );
$documentCountLimit                         = isset( $siteInfo['documentCountLimit'] ) ? esc_html( $siteInfo['documentCountLimit'] ) : __( 'N/A', 'chilisearch' );
$referralGiftCodeCode                       = isset( $siteInfo['referralGiftCode']->code ) ? esc_html( $siteInfo['referralGiftCode']->code ) : __( 'N/A', 'chilisearch' );
$referralGiftCodeAddDays                    = isset( $siteInfo['referralGiftCode']->addDays ) ? esc_html( $siteInfo['referralGiftCode']->addDays ) : __( 'N/A', 'chilisearch' );
$referralGiftCodeIncreaseDocumentCountLimit = isset( $siteInfo['referralGiftCode']->increaseDocumentCountLimit ) ? esc_html( $siteInfo['referralGiftCode']->increaseDocumentCountLimit ) : __( 'N/A', 'chilisearch' );
$thisMonthRequestCount                      = isset( $siteInfo['thisMonthRequestCount'] ) ? esc_html( $siteInfo['thisMonthRequestCount'] ) : __( 'N/A', 'chilisearch' );
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
            <p class="card-category"><?= __( 'Plan', 'chilisearch' ) ?>:</p>
            <h3 class="card-title"><?= ucfirst( $plan ) ?><?= ! empty( $planInfo ) ? " <small style='font-weight: normal'>$planInfo</small>" : '' ?></h3>
            <a href="<?= admin_url( 'admin.php?page=chilisearch&tab=plans' ) ?>"><?= __( 'See Plans', 'chilisearch' ) ?> →</a>
            <a href="javascript:;" onclick="jQuery('#gift-code-holder').slideToggle()" style="margin-left: 10px"><?= __( 'Redeem Gift Code', 'chilisearch' ) ?> →</a>
            <?php if ( empty( $siteInfo['usedTrialBefore'] ) && $plan === 'basic' ): ?>
                <a href="javascript:;" onclick="jQuery('#gift-code-holder input').val('trial');jQuery('#gift-code-holder').submit()" style="margin-left: 10px"><?= __( 'Start 7-Days Trial', 'chilisearch' ) ?> →</a>
            <?php endif; ?>
            <form style="display: none;margin-top: 10px;" id="gift-code-holder" action="<?= admin_url( 'admin.php?page=chilisearch&tab=analytics' ) ?>" method="post">
                <input type="text" name="gift-code" placeholder="<?= __( 'Enter Your Gift Code …', 'chilisearch' ) ?>">
                <button type="submit" class="button button-primary"><?= __( 'Submit', 'chilisearch' ) ?></button>
            </form>
        </div>
    </div>
    <div class="card card-stats">
        <div class="card-header card-header-warning card-header-icon">
            <p class="card-category">
                <label><?= __( 'Your Gift-Code:', 'chilisearch' ) ?><input onClick="this.select();" type="text" value="<?= $referralGiftCodeCode ?>" style="margin-left:3px;border:0!important;box-shadow:none;background-color:transparent;text-transform:uppercase;" readonly></label>
            </p>
            <p class="card-body">
                <?= sprintf( __( 'Gift your friends %s days free Chili Search Premium and increase your document limit by %s.', 'chilisearch' ), $referralGiftCodeAddDays, $referralGiftCodeIncreaseDocumentCountLimit ) ?>
            </p>
        </div>
    </div>
    <div class="card card-stats">
        <div class="card-header card-header-info card-header-icon">
            <p class="card-category"><?= __( 'Number of Indexed Documents', 'chilisearch' ) ?>:</p>
            <h3 class="card-title"><?= $documentsCount ?><small>/<?= $documentCountLimit ?></small></h3>
            <a href="<?= admin_url( 'admin.php?page=chilisearch&tab=where-to-search' ) ?>"><?= __( 'Manage', 'chilisearch' ) ?> →</a>
            <a href="<?= admin_url( 'admin.php?page=chilisearch&tab=plans' ) ?>" style="margin-left: 10px"><?= __( 'Want More?', 'chilisearch' ) ?> →</a>
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
