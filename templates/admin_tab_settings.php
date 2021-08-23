<?php
$plan = ChiliSearch::getInstance()->get_current_plan();
$search_page = get_page_by_title(wp_strip_all_tags( __( 'Search' ) ));
?>
<style>
</style>
<div class="wrap">
    <form method="post" action="options.php" id="site_config_update">
        <?php settings_fields( 'chilisearch_settings_group' ); ?>
        <table class="form-table">
            <tbody>
            <tr valign="top">
                <th scope="row"><label for="fuzzy_search_enabled"><?= __( 'Fuzzy search', 'chilisearch' ) ?></label></th>
                <td>
                    <label>
                        <input type="checkbox" name="chilisearch_settings[fuzzy_search_enabled]" id="fuzzy_search_enabled" value="true" <?= $this->settings['fuzzy_search_enabled'] ? 'checked' : '' ?>>
                        <?= __( 'Enable', 'chilisearch' ) ?>
                        <p class="description"><?= __( 'Enable fuzzy searching.', 'chilisearch' ) ?> <a href="https://en.wikipedia.org/wiki/Approximate_string_matching" target="_blank"><?= __( 'more info', 'chilisearch' ) ?></a></p>
                    </label>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="voice_search_enabled"><?= __( 'Voice search', 'chilisearch' ) ?></label></th>
                <td>
                    <label>
                        <input type="checkbox" name="chilisearch_settings[voice_search_enabled]" id="voice_search_enabled" value="true" <?= $this->settings['voice_search_enabled'] ? 'checked' : '' ?>>
                        <?= __( 'Enable', 'chilisearch' ) ?>
                        <p class="description"><?= __( 'Enable search using voice.', 'chilisearch' ) ?></p>
                    </label>
                    <small><?= sprintf(__( 'Only works in supported browsers %shere%s.', 'chilisearch' ), '<a href="https://developer.mozilla.org/docs/Web/API/SpeechRecognition#browser_compatibility" target="_blank">', '</a>') ?></small>
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
                <th scope="row"><label for="search_page_id"><?= __( 'Search result page', 'chilisearch' ) ?></label></th>
                <td>
                    <label>
                        <select name="chilisearch_settings[search_page_id]" id="search_page_id" class="regular-text">
                            <option value="-1" <?= ! isset( $this->settings['search_page_id'] ) || $this->settings['search_page_id'] == - 1 ? 'selected' : '' ?>><?= __( 'Chili Search result page', 'chilisearch' ); ?></option>
                            <?php if ( ! empty( $search_page && $search_page->post_status === 'publish' ) ): ?>
                                <option value="<?= $search_page->ID ?>" <?= isset( $this->settings['search_page_id'] ) && $this->settings['search_page_id'] == $search_page->ID ? 'selected' : '' ?>><?= sprintf( '%s (%s) ', $search_page->post_title, get_permalink( $search_page->ID ) ) ?></option>
                            <?php endif; ?>
                        </select>
                        <?php if ( empty( $search_page ) ): ?>
                            <button type="button" class="button button-primary" id="create_set_search_page"><?= __( 'Create Search Page (recommended)', 'chilisearch' ); ?></button>
                        <?php else: ?>
                            <a href="post.php?post=<?= $search_page->ID ?>&action=edit" class="button button-primary" target="_blank"><?= __( 'Edit Search Page', 'chilisearch' ); ?></a>
                        <?php endif; ?>
                        <p class="description"><?= __( 'Choose the search result page.', 'chilisearch' ) ?></p>
                    </label>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="search_input_selector"><?= __( 'Auto search input selector', 'chilisearch' ) ?></label></th>
                <td>
                    <label>
                        <input type="text" name="chilisearch_settings[search_input_selector]" id="search_input_selector" class="regular-text" value="<?php echo esc_attr( ! empty( $this->settings['search_input_selector'] ) ? $this->settings['search_input_selector'] : '' ); ?>"/>
                        <p class="description"><?= __( 'Search input selector, in case the search input is not detected automatically. Don\'t change it if search is working correctly.', 'chilisearch' ) ?></p>
                    </label>
                </td>
            </tr>
            </tbody>
        </table>
        <div class="<?= $plan !== 'premium' ? 'premium-box' : '' ?>">
            <h3><?= __( 'Premium Features', 'chilisearch' ) ?>:</h3>
            <table class="form-table">
                <tbody>
                <tr valign="top">
                    <th scope="row"><label for="search_word_type"><?= __( 'Search type', 'chilisearch' ) ?></label></th>
                    <td>
                        <label>
                            <select name="chilisearch_settings[search_word_type]" id="search_word_type" class="regular-text" <?= $plan !== 'premium' ? 'disabled="disabled"' : '' ?>>
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
                            <select name="chilisearch_settings[sort_by]" id="sort_by" class="regular-text" <?= $plan !== 'premium' ? 'disabled="disabled"' : '' ?>>
                                <?php foreach ( ChiliSearch::get_sort_bys() as $sort_by => $sort_by_name ): ?>
                                <option value="<?= $sort_by ?>" <?= $this->settings['sort_by'] === $sort_by ? 'selected' : '' ?> <?= ($sort_by === self::SORT_BY_PRICE_DESC || $sort_by === self::SORT_BY_PRICE_ASC) && empty( $this->is_woocommerce_active() ) ? 'disabled="disabled"' : '' ?>><?= $sort_by_name ?></option>
                                <?php endforeach; ?>
                            </select>
                            <p class="description"><?= __( 'Sort search result by.', 'chilisearch' ) ?></p>
                        </label>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label><?= __( 'Facets', 'chilisearch' ) ?></label></th>
                    <td id="facets" class="sub-labels">
                        <label for="facet_categories">
                            <span><?= __( 'Categories', 'chilisearch' ) ?>: </span>
                            <input type="checkbox" name="chilisearch_settings[facet_categories]" id="facet_categories" class="regular-text" value="true" <?= in_array( self::FACET_CATEGORIES, $this->settings['facets'], true ) ? 'checked="checked"' : '' ?> <?= $plan !== 'premium' ? 'disabled="disabled"' : '' ?>/>
                        </label>
                        <label for="facet_tags">
                            <span><?= __( 'Tags', 'chilisearch' ) ?>: </span>
                            <input type="checkbox" name="chilisearch_settings[facet_tags]" id="facet_tags" class="regular-text" value="true" <?= in_array( self::FACET_TAGS, $this->settings['facets'], true ) ? 'checked="checked"' : '' ?> <?= $plan !== 'premium' ? 'disabled="disabled"' : '' ?>/>
                        </label>
                        <label for="facet_author">
                            <span><?= __( 'Author', 'chilisearch' ) ?>: </span>
                            <input type="checkbox" name="chilisearch_settings[facet_author]" id="facet_author" class="regular-text" value="true" <?= in_array( self::FACET_AUTHOR, $this->settings['facets'], true ) ? 'checked="checked"' : '' ?> <?= $plan !== 'premium' ? 'disabled="disabled"' : '' ?>/>
                        </label>
                        <label for="facet_brand">
                            <span><?= __( 'Brand', 'chilisearch' ) ?>: </span>
                            <input type="checkbox" name="chilisearch_settings[facet_brand]" id="facet_brand" class="regular-text" value="true" <?= in_array( self::FACET_BRAND, $this->settings['facets'], true ) ? 'checked="checked"' : '' ?> <?= $plan !== 'premium' ? 'disabled="disabled"' : '' ?>/>
                        </label>
                        <label for="facet_type">
                            <span><?= __( 'Type', 'chilisearch' ) ?>: </span>
                            <input type="checkbox" name="chilisearch_settings[facet_type]" id="facet_type" class="regular-text" value="true" <?= in_array( self::FACET_TYPE, $this->settings['facets'], true ) ? 'checked="checked"' : '' ?> <?= $plan !== 'premium' ? 'disabled="disabled"' : '' ?>/>
                        </label>
                        <label for="facet_price">
                            <span><?= __( 'Price', 'chilisearch' ) ?>: </span>
                            <input type="checkbox" name="chilisearch_settings[facet_price]" id="facet_price" class="regular-text" value="true" <?= in_array( self::FACET_PRICE, $this->settings['facets'], true ) ? 'checked="checked"' : '' ?> <?= !$this->is_woocommerce_active() || $plan !== 'premium' ? 'disabled="disabled"' : '' ?>/>
                        </label>
                        <label for="facet_publishedAt">
                            <span><?= __( 'Published At', 'chilisearch' ) ?>: </span>
                            <input type="checkbox" name="chilisearch_settings[facet_publishedAt]" id="facet_publishedAt" class="regular-text" value="true" <?= in_array( self::FACET_PUBLISHED_AT, $this->settings['facets'], true ) ? 'checked="checked"' : '' ?> <?= $plan !== 'premium' ? 'disabled="disabled"' : '' ?>/>
                        </label>
                        <label for="facet_status">
                            <span><?= __( 'Status', 'chilisearch' ) ?>: </span>
                            <input type="checkbox" name="chilisearch_settings[facet_status]" id="facet_status" class="regular-text" value="true" <?= in_array( self::FACET_STATUS, $this->settings['facets'], true ) ? 'checked="checked"' : '' ?> <?= !$this->is_woocommerce_active() || $plan !== 'premium' ? 'disabled="disabled"' : '' ?>/>
                        </label>
                        <p class="description"><?= __( 'Define active search filters.', 'chilisearch' ) ?></p>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label><?= __( 'Field weights', 'chilisearch' ) ?></label></th>
                    <td id="weights" class="sub-labels">
                        <label for="weight_title">
                            <span><?= __( 'Title', 'chilisearch' ) ?>: </span>
                            <input type="number" name="chilisearch_settings[weight_title]" id="weight_title" class="regular-text" min="1" max="10" value="<?= $this->settings['weight_title'] ?>" <?= $plan !== 'premium' ? 'disabled="disabled"' : '' ?>/>
                        </label>
                        <label for="weight_excerpt">
                            <span><?= __( 'Excerpt', 'chilisearch' ) ?>: </span>
                            <input type="number" name="chilisearch_settings[weight_excerpt]" id="weight_excerpt" class="regular-text" min="0" max="10" value="<?= $this->settings['weight_excerpt'] ?>" <?= $plan !== 'premium' ? 'disabled="disabled"' : '' ?>/>
                        </label>
                        <label for="weight_body">
                            <span><?= __( 'Body', 'chilisearch' ) ?>: </span>
                            <input type="number" name="chilisearch_settings[weight_body]" id="weight_body" class="regular-text" min="0" max="10" value="<?= $this->settings['weight_body'] ?>" <?= $plan !== 'premium' ? 'disabled="disabled"' : '' ?>/>
                        </label>
                        <label for="weight_tags">
                            <span><?= __( 'Tags', 'chilisearch' ) ?>: </span>
                            <input type="number" name="chilisearch_settings[weight_tags]" id="weight_tags" class="regular-text" min="0" max="10" value="<?= $this->settings['weight_tags'] ?>" <?= $plan !== 'premium' ? 'disabled="disabled"' : '' ?>/>
                        </label>
                        <label for="weight_categories">
                            <span><?= __( 'Category', 'chilisearch' ) ?>: </span>
                            <input type="number" name="chilisearch_settings[weight_categories]" id="weight_categories" class="regular-text" min="0" max="10" value="<?= $this->settings['weight_categories'] ?>" <?= $plan !== 'premium' ? 'disabled="disabled"' : '' ?>/>
                        </label>
                        <p class="description"><?= __( 'Define weight for each field of the document.', 'chilisearch' ) ?></p>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label for="display_result_product_price"><?= __( 'Display product price', 'chilisearch' ) ?></label></th>
                    <td>
                        <label>
                            <input type="checkbox" name="chilisearch_settings[display_result_product_price]" id="display_result_product_price" value="true" <?= $this->is_woocommerce_active() && $this->settings['display_result_product_price'] ? 'checked' : '' ?> <?= $plan !== 'premium' || !$this->is_woocommerce_active() ? 'disabled="disabled"' : '' ?>>
                            <?= __( 'Display', 'chilisearch' ) ?> <small><?= !$this->is_woocommerce_active() ? __('(WooCommerce plugin is not installed)', 'chilisearch') : '' ?></small>
                            <p class="description"><?= __( 'Display product price in search result.', 'chilisearch' ) ?></p>
                        </label>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label for="display_result_product_add_to_cart"><?= __( 'Display add-to-cart button', 'chilisearch' ) ?></label></th>
                    <td>
                        <label>
                            <input type="checkbox" name="chilisearch_settings[display_result_product_add_to_cart]" id="display_result_product_add_to_cart" value="true" <?= $this->is_woocommerce_active() && $this->settings['display_result_product_add_to_cart'] ? 'checked' : '' ?> <?= $plan !== 'premium' || !$this->is_woocommerce_active() ? 'disabled="disabled"' : '' ?>>
                            <?= __( 'Display', 'chilisearch' ) ?> <small><?= !$this->is_woocommerce_active() ? __('(WooCommerce plugin is not installed)', 'chilisearch') : '' ?></small>
                            <p class="description"><?= __( 'Display add-to-cart button in search result.', 'chilisearch' ) ?></p>
                        </label>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label for="display_chilisearch_brand"><?= __( 'Display Chili Search brand', 'chilisearch' ) ?></label></th>
                    <td>
                        <label>
                            <input type="checkbox" name="chilisearch_settings[display_chilisearch_brand]" id="display_chilisearch_brand" value="true" <?= $this->settings['display_chilisearch_brand'] ? 'checked' : '' ?> <?= $plan !== 'premium' ? 'disabled="disabled"' : '' ?>>
                            <?= __( 'Display', 'chilisearch' ) ?>
                            <p class="description"><?= __( 'Display Chili Search brand in search box and search result.', 'chilisearch' ) ?></p>
                        </label>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <p class="submit">
            <input type="submit" name="submit" id="submit" class="button button-primary" value="<?= __( 'Save Changes' ) ?>">
            <span style="float: none;margin-top: -3px;display: none;" id="spinner" class="spinner is-active"></span>
            <span id="save_result" style="display: none;"></span>
        </p>
    </form>
</div>
<script type="text/javascript">
    jQuery(document).ready(function ($) {
        let spinner = jQuery('#spinner');
        let save_result = jQuery('#save_result');
        jQuery('#site_config_update').submit(function (e) {
            e.preventDefault();
            spinner.show();
            save_result.hide();
            window.scrollTo({ top: document.body.scrollHeight, behavior: 'smooth' })
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
                    'fuzzy_search_enabled': jQuery('#site_config_update #fuzzy_search_enabled').is(":checked"),
                    'voice_search_enabled': jQuery('#site_config_update #voice_search_enabled').is(":checked"),
                    'display_result_product_price': jQuery('#site_config_update #display_result_product_price').is(":checked"),
                    'display_result_product_add_to_cart': jQuery('#site_config_update #display_result_product_add_to_cart').is(":checked"),
                    'display_chilisearch_brand': jQuery('#site_config_update #display_chilisearch_brand').is(":checked"),
                    'weight_title': jQuery('#site_config_update #weight_title').val(),
                    'weight_excerpt': jQuery('#site_config_update #weight_excerpt').val(),
                    'weight_body': jQuery('#site_config_update #weight_body').val(),
                    'weight_tags': jQuery('#site_config_update #weight_tags').val(),
                    'weight_categories': jQuery('#site_config_update #weight_categories').val(),
                    'facet_categories': jQuery('#site_config_update #facet_categories').is(":checked"),
                    'facet_tags': jQuery('#site_config_update #facet_tags').is(":checked"),
                    'facet_author': jQuery('#site_config_update #facet_author').is(":checked"),
                    'facet_brand': jQuery('#site_config_update #facet_brand').is(":checked"),
                    'facet_type': jQuery('#site_config_update #facet_type').is(":checked"),
                    'facet_price': jQuery('#site_config_update #facet_price').is(":checked"),
                    'facet_publishedAt': jQuery('#site_config_update #facet_publishedAt').is(":checked"),
                    'facet_status': jQuery('#site_config_update #facet_status').is(":checked"),
                },
                function (response) {
                    spinner.hide();
                    jQuery('#site_config_update button[type="submit"]').prop('disabled', false)
                    if (response.status) {
                        save_result.text('<?= __( 'Settings saved.', 'chilisearch' ) ?>').css('color', '#077907').show();
                    } else {
                        save_result.text(response.message).css('color', '#dc0f0f').show();
                    }
                }
            );
            return false;
        });
        jQuery('#site_config_update #create_set_search_page').click(function () {
            spinner.show();
            save_result.hide();
            window.scrollTo({ top: document.body.scrollHeight, behavior: 'smooth' })
            jQuery(this).prop('disabled', true)
            jQuery.post(
                ajaxurl,
                {
                    'action': 'admin_ajax_create_set_search_page',
                },
                function (response) {
                    spinner.hide();
                    jQuery(this).prop('disabled', false)
                    if (response.status) {
                        save_result.text('<?= __( 'Settings saved.', 'chilisearch' ) ?>').css('color', '#077907').show();
                        window.location.replace("<?= admin_url( 'admin.php?page=chilisearch&tab=settings' ) ?>");
                    } else {
                        save_result.text('<?= __( 'Something went wrong! please try again.', 'chilisearch' ) ?>').css('color', '#dc0f0f').show();
                    }
                }
            );
            return false;
        });
    });
</script>
