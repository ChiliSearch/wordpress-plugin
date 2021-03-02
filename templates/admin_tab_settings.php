<?php ob_start(); ?>
<div class="wrap">
    <h2><?php _e( 'Settings', 'chilisearch' ); ?></h2>
    <form method="post" action="options.php" id="site_config_update">
        <div class="message-box"></div>
        <?php settings_fields( 'chilisearch_settings_group' ); ?>
        <table class="form-table">
            <tbody>
            <tr valign="top">
                <th scope="row"><label><?= __('Search result page', 'chilisearch') ?></label></th>
                <td>
                    <label>
                        <select name="chilisearch_settings[search_page_id]" id="search_page_id" class="regular-text">
                            <option value="-1" <?= !isset($this->settings['search_page_id']) || $this->settings['search_page_id'] == -1 ? 'selected' : '' ?>><?= __('Chili Search result page (not recommended)', 'chilisearch'); ?></option>
                            <?php foreach (get_pages(['post_type' => 'page', 'post_status' => 'publish']) as $page): ?>
                                <option value="<?= $page->ID ?>" <?= isset($this->settings['search_page_id']) && $this->settings['search_page_id'] == $page->ID ? 'selected' : '' ?>><?= sprintf('%s (%s) ', $page->post_title, get_permalink($page->ID)) ?></option>
                            <?php endforeach; ?>
                        </select>
	                    <?php if (!isset($this->settings['search_page_id']) || $this->settings['search_page_id'] == -1): ?><button type="button" class="button button-primary" id="create_set_search_page"><?= __('Create Search Page (recommended)', 'chilisearch'); ?></button><?php endif; ?>
                        <p class="description"><?= __('Choose the search result page', 'chilisearch') ?></p>
                    </label>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row"><label><?= __('Search page results number', 'chilisearch') ?></label></th>
                <td>
                    <label>
                        <input type="number" name="chilisearch_settings[search_page_size]" id="search_page_size" class="regular-text" min="1" max="20" value="<?= esc_attr($this->settings['search_page_size']) ?>"/>
                        <p class="description"><?= __('Number of results displayed in search page.', 'chilisearch') ?></p>
                    </label>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row"><label><?= __('SAYT (search as you type) results number', 'chilisearch') ?></label></th>
                <td>
                    <label>
                        <input type="number" name="chilisearch_settings[sayt_page_size]" id="sayt_page_size" class="regular-text" min="1" max="10" value="<?= esc_attr($this->settings['sayt_page_size']) ?>"/>
                        <p class="description"><?= __('Number of results displayed in SAYT box.', 'chilisearch') ?></p>
                    </label>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row"><label><?= __('Search input selector', 'chilisearch') ?></label></th>
                <td>
                    <label>
                        <input type="text" name="chilisearch_settings[search_input_selector]" id="search_input_selector" class="regular-text" value="<?php echo esc_attr(!empty($this->settings['search_input_selector']) ? $this->settings['search_input_selector'] : ''); ?>"/>
                        <p class="description"><?= __('Search input selector, in case the search input is not detected automatically. Don\'t change it if search is working correctly.', 'chilisearch') ?></p>
                    </label>
                </td>
            </tr>
            </tbody>
        </table>
        <?php submit_button(); ?>
    </form>
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
                        jQuery('#site_config_update .message-box').html('<div class="notice notice-success is-dismissible"><p><strong><?= __('Settings saved.', 'chilisearch') ?></strong></p></div>')
                        return;
                    }
                    jQuery('#site_config_update button[type="submit"]').prop('disabled', false)
                    jQuery('#site_config_update .message-box').html('<div class="notice notice-error is-dismissible"><p><strong>' + response.message + '</strong></p></div>')
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
                        window.location.replace("<?= admin_url('admin.php?page=chilisearch&tab=settings') ?>");
                        return;
                    }
                    jQuery(this).prop('disabled', false)
                    alert('<?= __('Something went wrong! please try again.', 'chilisearch'); ?>');
                }
            );
            return false;
        });
    });
</script>
<?= ob_get_clean() ?>