<div class="container">
    <div class="row mt-5">
        <div class="col-lg-4 col-md-6 col-sm-6">
            <div class="card card-stats">
                <div class="card-header card-header-warning card-header-icon">
                    <div class="card-icon">
                        <i class="material-icons">storage</i>
                    </div>
                    <p class="card-category"><?= __('Used Space', 'searchili') ?></p>
                    <h3 class="card-title"><?= isset($siteInfo->usedSpace) ? esc_html($siteInfo->usedSpace) : __('N/A', 'searchili') ?></h3>
                </div>
                <div class="card-footer">
                    <div class="stats">
                        <i class="material-icons">link</i>
                        <a href="https://app.searchi.li" target="_blank"><?= __('Get More Details', 'searchili') ?></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-6">
            <div class="card card-stats">
                <div class="card-header card-header-success card-header-icon">
                    <div class="card-icon">
                        <i class="material-icons">check_circle</i>
                    </div>
                    <p class="card-category"><?= __('Number of Searches', 'searchili') ?></p>
                    <h3 class="card-title"><?= isset($siteInfo->thisMonthRequestCount) ? esc_html($siteInfo->thisMonthRequestCount) : __('N/A', 'searchili') ?></h3>
                </div>
                <div class="card-footer">
                    <div class="stats">
                        <i class="material-icons">date_range</i> <?= sprintf(__('Since first of %s', 'searchili'), date( 'F' )) ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-6">
            <div class="card card-stats">
                <div class="card-header card-header-info card-header-icon">
                    <div class="card-icon">
                        <i class="material-icons">dns</i>
                    </div>
                    <p class="card-category"><?= __('Number of Indexed Posts', 'searchili') ?></p>
                    <h3 class="card-title"><?= isset($siteInfo->thisMonthRequestCount) ? esc_html($siteInfo->entitiesCount) : __('N/A', 'searchili') ?></h3>
                </div>
                <div class="card-footer">
                    <div class="stats">
                        <i class="material-icons">link</i>
                        <a href="https://app.searchi.li" target="_blank"><?= __('Get More Details', 'searchili') ?></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-8 col-md-12">
            <div class="card" style="max-width: 100%;">
                <div class="card-header card-header-primary">
                    <h4 class="card-title"><?= __('Settings', 'searchili') ?></h4>
                    <p class="card-category"><?= __('Customize your user search experience.', 'searchili') ?></p>
                </div>
                <div class="card-body">
                    <form method="post" action="" id="site_config_update">
                        <table class="form-table">
                            <tbody>
                            <tr>
                                <th scope="row"><label for="search_page_id"><?= __('Search result page', 'searchili'); ?></label></th>
                                <td>
                                    <label>
                                        <select name="search_page_id" id="search_page_id" class="regular-text">
                                            <option value="-1" <?= $this->settings['search_page_id'] == -1 ? 'selected' : '' ?>><?= __('SearChili result page (not recommended)', 'searchili'); ?></option>
				                            <?php foreach (get_pages(['post_type' => 'page', 'post_status' => 'publish']) as $page): ?>
                                            <option value="<?= $page->ID ?>" <?= $this->settings['search_page_id'] == $page->ID ? 'selected' : '' ?>><?= sprintf('%s (%s) ', $page->post_title, $page->guid) ?></option>
				                            <?php endforeach; ?>
                                        </select>
                                    </label>
                                    <div class="clearfix"></div>
		                            <?php if (!isset($this->settings['search_page_id']) || $this->settings['search_page_id'] == -1): ?><button type="button" class="btn btn-primary btn-sm" id="create_set_search_page"><?= __('Create Search Page (recommended)', 'searchili'); ?></button><?php endif; ?>
                                    <div class="clearfix"></div>
                                    <small class="description"><?= __('Choose the search result page.', 'searchili'); ?></small>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="search_page_size"><?= __('Search page results number', 'searchili'); ?></label></th>
                                <td>
                                    <label>
                                        <input type="number" name="search_page_size" id="search_page_size" class="regular-text" min="1" max="20" value="<?php echo esc_attr(!empty($this->settings['search_page_size']) ? intval($this->settings['search_page_size']) : 15); ?>"/>
                                    </label>
                                    <div class="clearfix"></div>
                                    <small class="description"><?= __('Number of results displayed in search page.', 'searchili'); ?></small>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="sayt_page_size"><?= __('SAYT (search as you type) results number', 'searchili'); ?></label></th>
                                <td>
                                    <label>
                                        <input type="number" name="sayt_page_size" id="sayt_page_size" class="regular-text" min="1" max="10" value="<?php echo esc_attr(!empty($this->settings['sayt_page_size']) ? intval($this->settings['sayt_page_size']) : 5); ?>"/>
                                    </label>
                                    <div class="clearfix"></div>
                                    <small class="description"><?= __('Number of results displayed in SAYT box.', 'searchili'); ?></small>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="search_input_selector"><?= __('Search input selector', 'searchili'); ?></label></th>
                                <td>
                                    <label>
                                        <input type="text" name="search_input_selector" id="search_input_selector" class="regular-text" value="<?php echo esc_attr(!empty($this->settings['search_input_selector']) ? $this->settings['search_input_selector'] : ''); ?>"/>
                                    </label>
                                    <div class="clearfix"></div>
                                    <small class="description"><?= __('Search input selector, in case the search input is not detected automatically. Don\'t change it if search is working correctly.', 'searchili'); ?></small>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <button type="submit" class="btn btn-primary"><?= __('Submit', 'searchili'); ?></button>
                        <a href="<?= esc_url(admin_url('admin.php?page=searchili&changeAPI')) ?>" class="btn btn-warning float-right"><?= __('change API key', 'searchili'); ?></a>
                        <a href="<?= esc_url(admin_url('admin.php?page=searchili&indexConfig')) ?>" class="btn btn-warning float-right"><?= __('update index config', 'searchili'); ?></a>
                        <div class="clearfix"></div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-12">
            <div class="card">
                <div class="card-header card-header-success">
                    <h4 class="card-title"><?= __('Top searched terms', 'searchili'); ?></h4>
                    <p class="card-category"><?= __('Most searched terms.', 'searchili'); ?></p>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-hover">
                        <thead class="text-warning">
                        <th>ID</th>
                        <th>Term</th>
                        <th>Count</th>
                        </thead>
                        <tbody>
                        <tr>
                            <td>1</td>
                            <td>Lorem ipsum</td>
                            <td>36,738</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>dolor</td>
                            <td>23,789</td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>sit amet</td>
                            <td>16,142</td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>consectetur</td>
                            <td>8,735</td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>adipiscing</td>
                            <td>5,256</td>
                        </tr>
                        </tbody>
                    </table>
                    <div id="blur-overlay" style="background-color: rgba(255,255,255, 0.7);color: #000;font-size: 21px;position: absolute;top: 0;left: 0;z-index: 7;width: 100%;height: 100%;text-align: center;line-height: 20px;padding-top: 120px;"><?= __('coming soon!', 'searchili'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    jQuery(document).ready(function ($) {
        jQuery('#site_config_update').submit(function (e) {
            e.preventDefault();
            jQuery('#site_config_update button[type="submit"]').prop('disabled', true)
            jQuery.post(
                ajaxurl,
                {
                    'action': 'admin_ajax_config_update',
                    'search_page_size': jQuery('#site_config_update #search_page_size').val(),
                    'sayt_page_size': jQuery('#site_config_update #sayt_page_size').val(),
                    'search_input_selector': jQuery('#site_config_update #search_input_selector').val(),
                    'search_page_id': jQuery('#site_config_update #search_page_id').val(),
                },
                function (response) {
                    if (response.status) {
                        location.reload();
                        return;
                    }
                    jQuery('#site_config_update button[type="submit"]').prop('disabled', false)
                    alert(response.message);
                }
            );
            return false;
        });
        jQuery('#site_config_update #create_set_search_page').click(function () {
            jQuery(this).prop('disabled', true)
            jQuery.post(
                ajaxurl,
                {
                    'action': 'admin_ajax_create_set_search_page',
                },
                function (response) {
                    if (response.status) {
                        window.location.replace("<?= esc_url(admin_url('admin.php?page=searchili')) ?>");
                        return;
                    }
                    jQuery(this).prop('disabled', false)
                    alert('<?= __('Something went wrong! please try again.', 'searchili'); ?>');
                }
            );
            return false;
        });
    });
</script>
