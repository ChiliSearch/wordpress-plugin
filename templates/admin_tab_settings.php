<style>
    #weights label {
        display: block;
        margin: 5px;
    }
    #weights label span {
        width: 100px;
        display: inline-block;
    }
    #weights label input {
        width: 50px;
    }
</style>
<div class="wrap">
    <h2><?php _e( 'Settings', 'chilisearch' ); ?></h2>
    <?php if ( isset( $_GET['saved'] ) ): ?>
        <div class="notice notice-success is-dismissible" style="margin-top: 20px;">
            <p>
                <strong><?= __( 'Settings saved.', 'chilisearch' ) ?></strong>
            </p>
        </div>
    <?php endif ?>
    <form method="post" action="options.php" id="site_config_update">
        <?php settings_fields( 'chilisearch_settings_group' ); ?>
        <table class="form-table">
            <tbody>
            <tr valign="top">
                <th scope="row"><label for="search_word_type"><?= __( 'Search type', 'chilisearch' ) ?></label></th>
                <td>
                    <label>
                        <select name="chilisearch_settings[search_word_type]" id="search_word_type" class="regular-text">
                            <?php foreach ( ChiliSearch::get_word_types() as $search_word_type => $search_word_type_name ): ?>
                                <option value="<?= $search_word_type ?>" <?= $this->settings['search_word_type'] === $search_word_type ? 'selected' : '' ?>><?= $search_word_type_name ?></option>
                            <?php endforeach; ?>
                        </select>
                        <p class="description"><?= __( 'Match the whole word, partial word or both.', 'chilisearch' ) ?></p>
                    </label>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="sort_by"><?= __( 'Sort by', 'chilisearch' ) ?></label></th>
                <td>
                    <label>
                        <select name="chilisearch_settings[sort_by]" id="sort_by" class="regular-text">
                            <?php foreach ( ChiliSearch::get_sort_bys() as $sort_by => $sort_by_name ): ?>
                                <option value="<?= $sort_by ?>" <?= $this->settings['sort_by'] === $sort_by ? 'selected' : '' ?> <?= ($sort_by === self::SORT_BY_PRICE_DESC || $sort_by === self::SORT_BY_PRICE_ASC) && empty( $this->wts_settings['woocommerce_products'] ) ? 'disabled="disabled"' : '' ?>><?= $sort_by_name ?></option>
                            <?php endforeach; ?>
                        </select>
                        <p class="description"><?= __( 'Sort search result by.', 'chilisearch' ) ?></p>
                    </label>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="display_result_image"><?= __( 'Display thumbnail', 'chilisearch' ) ?></label></th>
                <td>
                    <label>
                        <input type="checkbox" name="chilisearch_settings[display_result_image]" id="display_result_image" value="true" <?= $this->settings['display_result_image'] ? 'checked' : '' ?>>
                        <?= __( 'Display', 'chilisearch' ) ?>
                        <p class="description"><?= __( 'Display thumbnail in search result.', 'chilisearch' ) ?></p>
                    </label>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="display_result_excerpt"><?= __( 'Display excerpt', 'chilisearch' ) ?></label></th>
                <td>
                    <label>
                        <input type="checkbox" name="chilisearch_settings[display_result_excerpt]" id="display_result_excerpt" value="true" <?= $this->settings['display_result_excerpt'] ? 'checked' : '' ?>>
                        <?= __( 'Display', 'chilisearch' ) ?>
                        <p class="description"><?= __( 'Display excerpt in search result.', 'chilisearch' ) ?></p>
                    </label>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="display_result_categories"><?= __( 'Display categories', 'chilisearch' ) ?></label></th>
                <td>
                    <label>
                        <input type="checkbox" name="chilisearch_settings[display_result_categories]" id="display_result_categories" value="true" <?= $this->settings['display_result_categories'] ? 'checked' : '' ?>>
                        <?= __( 'Display', 'chilisearch' ) ?>
                        <p class="description"><?= __( 'Display categories in search result.', 'chilisearch' ) ?></p>
                    </label>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="display_result_tags"><?= __( 'Display tags', 'chilisearch' ) ?></label></th>
                <td>
                    <label>
                        <input type="checkbox" name="chilisearch_settings[display_result_tags]" id="display_result_tags" value="true" <?= $this->settings['display_result_tags'] ? 'checked' : '' ?>>
                        <?= __( 'Display', 'chilisearch' ) ?>
                        <p class="description"><?= __( 'Display tags in search result.', 'chilisearch' ) ?></p>
                    </label>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="display_result_product_price"><?= __( 'Display product price', 'chilisearch' ) ?></label></th>
                <td>
                    <label>
                        <input type="checkbox" name="chilisearch_settings[display_result_product_price]" id="display_result_product_price" value="true" <?= $this->wts_settings['woocommerce_products'] && $this->settings['display_result_product_price'] ? 'checked' : '' ?> <?= !$this->wts_settings['woocommerce_products'] ? 'disabled="disabled"' : '' ?>>
                        <?= __( 'Display', 'chilisearch' ) ?>
                        <p class="description"><?= __( 'Display product price in search result.', 'chilisearch' ) ?></p>
                    </label>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row"><label><?= __( 'Field weights', 'chilisearch' ) ?></label></th>
                <td id="weights">
                    <label for="weight_title">
                        <span><?= __( 'Title', 'chilisearch' ) ?>: </span>
                        <input type="number" name="chilisearch_settings[weight_title]" id="weight_title" class="regular-text" min="1" max="10" value="<?= $this->settings['weight_title'] ?>"/>
                    </label>
                    <label for="weight_excerpt">
                        <span><?= __( 'Excerpt', 'chilisearch' ) ?>: </span>
                        <input type="number" name="chilisearch_settings[weight_excerpt]" id="weight_excerpt" class="regular-text" min="0" max="10" value="<?= $this->settings['weight_excerpt'] ?>"/>
                    </label>
                    <label for="weight_body">
                        <span><?= __( 'Body', 'chilisearch' ) ?>: </span>
                        <input type="number" name="chilisearch_settings[weight_body]" id="weight_body" class="regular-text" min="0" max="10" value="<?= $this->settings['weight_body'] ?>"/>
                    </label>
                    <label for="weight_tags">
                        <span><?= __( 'Tags', 'chilisearch' ) ?>: </span>
                        <input type="number" name="chilisearch_settings[weight_tags]" id="weight_tags" class="regular-text" min="0" max="10" value="<?= $this->settings['weight_tags'] ?>"/>
                    </label>
                    <label for="weight_categories">
                        <span><?= __( 'Category', 'chilisearch' ) ?>: </span>
                        <input type="number" name="chilisearch_settings[weight_categories]" id="weight_categories" class="regular-text" min="0" max="10" value="<?= $this->settings['weight_categories'] ?>"/>
                    </label>
                    <p class="description"><?= __( 'Define weight for each field of the document.', 'chilisearch' ) ?></p>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="filter_type"><?= __( 'Enable type filter', 'chilisearch' ) ?></label></th>
                <td>
                    <label>
                        <input type="checkbox" name="chilisearch_settings[filter_type]" id="filter_type" value="true" <?= $this->settings['filter_type'] ? 'checked' : '' ?>>
                        <?= __( 'Enable', 'chilisearch' ) ?>
                        <p class="description"><?= __( 'Enable filtering base on document type.', 'chilisearch' ) ?></p>
                    </label>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="filter_category"><?= __( 'Enable category filter', 'chilisearch' ) ?></label></th>
                <td>
                    <label>
                        <input type="checkbox" name="chilisearch_settings[filter_category]" id="filter_category" value="true" <?= $this->settings['filter_category'] ? 'checked' : '' ?>>
                        <?= __( 'Enable', 'chilisearch' ) ?>
                        <p class="description"><?= __( 'Enable filtering base on category.', 'chilisearch' ) ?></p>
                    </label>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="filter_publishedat"><?= __( 'Enable publish date filter', 'chilisearch' ) ?></label></th>
                <td>
                    <label>
                        <input type="checkbox" name="chilisearch_settings[filter_publishedat]" id="filter_publishedat" value="true" <?= $this->settings['filter_publishedat'] ? 'checked' : '' ?>>
                        <?= __( 'Enable', 'chilisearch' ) ?>
                        <p class="description"><?= __( 'Enable filtering base on publish date.', 'chilisearch' ) ?></p>
                    </label>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="filter_price"><?= __( 'Enable product price filter', 'chilisearch' ) ?></label></th>
                <td>
                    <label>
                        <input type="checkbox" name="chilisearch_settings[filter_price]" id="filter_price" value="true" <?= $this->settings['filter_price'] ? 'checked' : '' ?>  <?= !$this->wts_settings['woocommerce_products'] ? 'disabled="disabled"' : '' ?>>
                        <?= __( 'Enable', 'chilisearch' ) ?>
                        <p class="description"><?= __( 'Enable filtering base on product price.', 'chilisearch' ) ?></p>
                    </label>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="search_page_id"><?= __( 'Search result page', 'chilisearch' ) ?></label></th>
                <td>
                    <label>
                        <select name="chilisearch_settings[search_page_id]" id="search_page_id" class="regular-text">
                            <option value="-1" <?= ! isset( $this->settings['search_page_id'] ) || $this->settings['search_page_id'] == - 1 ? 'selected' : '' ?>><?= __( 'Chili Search result page (not recommended)', 'chilisearch' ); ?></option>
                            <?php foreach ( get_pages( [ 'post_type' => 'page', 'post_status' => 'publish' ] ) as $page ): ?>
                                <option value="<?= $page->ID ?>" <?= isset( $this->settings['search_page_id'] ) && $this->settings['search_page_id'] == $page->ID ? 'selected' : '' ?>><?= sprintf( '%s (%s) ', $page->post_title, get_permalink( $page->ID ) ) ?></option>
                            <?php endforeach; ?>
                        </select>
                        <?php if ( ! isset( $this->settings['search_page_id'] ) || $this->settings['search_page_id'] == - 1 ): ?><button type="button" class="button button-primary" id="create_set_search_page"><?= __( 'Create Search Page (recommended)', 'chilisearch' ); ?></button><?php endif; ?>
                        <p class="description"><?= __( 'Choose the search result page.', 'chilisearch' ) ?></p>
                    </label>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="search_page_size"><?= __( 'Search page results number', 'chilisearch' ) ?></label></th>
                <td>
                    <label>
                        <input type="number" name="chilisearch_settings[search_page_size]" id="search_page_size" class="regular-text" min="1" max="20" value="<?= esc_attr( $this->settings['search_page_size'] ) ?>"/>
                        <p class="description"><?= __( 'Number of results displayed in search page.', 'chilisearch' ) ?></p>
                    </label>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="sayt_page_size"><?= __( 'SAYT (search as you type) results number', 'chilisearch' ) ?></label></th>
                <td>
                    <label>
                        <input type="number" name="chilisearch_settings[sayt_page_size]" id="sayt_page_size" class="regular-text" min="1" max="10" value="<?= esc_attr( $this->settings['sayt_page_size'] ) ?>"/>
                        <p class="description"><?= __( 'Number of results displayed in SAYT box.', 'chilisearch' ) ?></p>
                    </label>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="search_input_selector"><?= __( 'Search input selector', 'chilisearch' ) ?></label></th>
                <td>
                    <label>
                        <input type="text" name="chilisearch_settings[search_input_selector]" id="search_input_selector" class="regular-text" value="<?php echo esc_attr( ! empty( $this->settings['search_input_selector'] ) ? $this->settings['search_input_selector'] : '' ); ?>"/>
                        <p class="description"><?= __( 'Search input selector, in case the search input is not detected automatically. Don\'t change it if search is working correctly.', 'chilisearch' ) ?></p>
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
                    'search_word_type': jQuery('#site_config_update #search_word_type').val(),
                    'sort_by': jQuery('#site_config_update #sort_by').val(),
                    'display_result_image': jQuery('#site_config_update #display_result_image').is(":checked"),
                    'display_result_product_price': jQuery('#site_config_update #display_result_product_price').is(":checked"),
                    'display_result_excerpt': jQuery('#site_config_update #display_result_excerpt').is(":checked"),
                    'display_result_categories': jQuery('#site_config_update #display_result_categories').is(":checked"),
                    'display_result_tags': jQuery('#site_config_update #display_result_tags').is(":checked"),
                    'weight_title': jQuery('#site_config_update #weight_title').val(),
                    'weight_excerpt': jQuery('#site_config_update #weight_excerpt').val(),
                    'weight_body': jQuery('#site_config_update #weight_body').val(),
                    'weight_tags': jQuery('#site_config_update #weight_tags').val(),
                    'weight_categories': jQuery('#site_config_update #weight_categories').val(),
                    'filter_type': jQuery('#site_config_update #filter_type').is(":checked"),
                    'filter_category': jQuery('#site_config_update #filter_category').is(":checked"),
                    'filter_publishedat': jQuery('#site_config_update #filter_publishedat').is(":checked"),
                    'filter_price': jQuery('#site_config_update #filter_price').is(":checked"),
                },
                function (response) {
                    if (response.status) {
                        window.location.replace("<?= admin_url( 'admin.php?page=chilisearch&tab=settings&saved' ) ?>");
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
                        window.location.replace("<?= admin_url( 'admin.php?page=chilisearch&tab=settings&saved' ) ?>");
                        return;
                    }
                    jQuery(this).prop('disabled', false)
                    alert('<?= __( 'Something went wrong! please try again.', 'chilisearch' ); ?>');
                }
            );
            return false;
        });
    });
</script>