<?php
/**
 * WP SearChili.
 *
 * WP SearChili plugin file.
 *
 * @package           SearChili
 * @author            Ali Jafari <ali@searchi.li>
 * @copyright         Copyright (C) 2021, SearChili - info@searchi.li
 *
 * @wordpress-plugin
 * Plugin Name:       SearChili
 * Plugin URI:        https://searchi.li
 * Description:       SearChili is an easy-to-use AI-powered Search as a Service that provides a better search experience in your website.
 * Version:           1.0.5
 * Author:            SearChili
 * Author URI:        https://searchi.li/
 * License:           GPLv2 or later
 * Text Domain:       searchili
 * Domain Path:       /languages
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

define('SEARCHILI_VERSION', '1.0.5');
define('SEARCHILI_DIR', dirname(__FILE__));
define('SEARCHILI_PHP_MINIMUM', '5.6.0');
define(
    'SEARCHILI_URL',
    strpos(home_url('/'), 'https://') !== false || strpos(plugin_dir_url(__FILE__), 'https://') !== false ?
        str_replace('http://', 'https://', plugin_dir_url(__FILE__)) : plugin_dir_url(__FILE__)
);

final class SearChili
{
    const SEARCHILI_BOB_BASE_URI = 'https://api.searchi.li/bob/v1/';
    const SEARCHILI_CDN_BASE_URI = 'https://cdn.searchi.li/alice/v1/';

    private static $instance = null;

    private $settings;

    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new SearChili();
        }
        return self::$instance;
    }

    private function __construct()
    {
        if ( version_compare( PHP_VERSION, SEARCHILI_PHP_MINIMUM, '<' ) ) {
            wp_die(
                esc_html( sprintf( __( 'SearChili requires PHP version %s', 'searchili' ), SEARCHILI_PHP_MINIMUM ) ),
                esc_html__( 'Error Activating', 'searchili' )
            );
        }

        $this->get_settings();

        $this->setup_client_actions();
        $this->setup_admin_actions();
    }

    private function get_settings($forceUpdate = false)
    {
        if ($forceUpdate || empty($this->settings)) {
            $this->settings = get_option('searchili_settings');
        }
        return $this->settings;
    }

    private function setup_client_actions()
    {
        add_action('plugins_loaded', [$this, 'i18n'], 2);
        add_action('wp', [$this, 'default_search_page']);
        add_action('wp_enqueue_scripts', [$this, 'client_enqueue_scripts']);
        add_shortcode('searchili_search_page', function() { return '<div id="searchili-search_page"></div>'; });
    }

	private function setup_admin_actions()
	{
        add_action('save_post', [$this, 'admin_save_post_hook'], 10, 3);
		if (!is_admin()) {
			return;
		}
		add_action('wp_ajax_admin_ajax_check_save_api_credentials', [$this, 'admin_ajax_check_save_api_credentials'] );
		add_action('wp_ajax_admin_ajax_index_config', [$this, 'wp_ajax_admin_ajax_index_config'] );
		add_action('wp_ajax_admin_ajax_config_update', [$this, 'wp_ajax_admin_ajax_config_update'] );
		add_action('wp_ajax_admin_ajax_create_set_search_page', [$this, 'wp_ajax_admin_ajax_create_set_search_page'] );
		add_action('wp_ajax_admin_ajax_get_list_of_ids_from_searchili', [$this, 'wp_ajax_admin_ajax_get_list_of_ids_from_searchili'] );
		add_action('wp_ajax_admin_ajax_get_list_of_content_need_to_be_indexed', [$this, 'wp_ajax_admin_ajax_get_list_of_content_need_to_be_indexed'] );
		add_action('wp_ajax_admin_ajax_delete_content_should_not_be_indexed', [$this, 'wp_ajax_admin_ajax_delete_content_should_not_be_indexed'] );
		add_action('wp_ajax_admin_ajax_index_missing_content', [$this, 'wp_ajax_admin_ajax_index_missing_content'] );
		add_filter('plugin_action_links_' . plugin_basename(__FILE__), function($links) {
			array_unshift($links, sprintf(
				'<a href="%s">%s</a>',
				esc_url(add_query_arg(array('page' => 'searchili'), admin_url('options-general.php'))),
				__('Settings', 'searchili')
			));
			return $links;
		});
		add_action('admin_menu', function() {
            add_menu_page(
                __('SearChili Settings', 'searchili'),
                __('SearChili', 'searchili'),
                apply_filters('searchili_settings_capability', 'manage_options'),
                'searchili',
                [$this, 'admin_searchili_options_page'],
                SEARCHILI_URL . 'icon.png'
            );
            add_submenu_page(
                'searchili',
                __('SearChili Settings', 'searchili'),
                __('Settings', 'searchili'),
                'manage_options',
                'searchili',
                [$this, 'admin_searchili_options_page']
            );
            add_submenu_page(
                'searchili',
                __('Indexing', 'searchili'),
                __('Indexing', 'searchili'),
                'manage_options',
                'searchili-indexing',
                [$this, 'admin_searchili_indexing_options_page']
            );
        });
		add_action('admin_init', function() {
            register_setting('searchili_settings_group', 'searchili_settings');
        });
		add_action('admin_notices', function () {
		    if (empty($this->settings['site_api_key'])) {
                echo '<div class="error"><p>'
                    . sprintf(__('SearChili: Enter site API Key in %ssettings%s page to enable SearChili.', 'searchili'),
                        '<a href="' . esc_url(admin_url('options-general.php?page=searchili')) . '">', '</a>')
                    . '</p></div>';
            }
		    if (empty($this->settings['site_api_secret']) && !empty($this->settings['site_api_key'])) {
                echo '<div class="error"><p>'
                    . sprintf(__('SearChili: Enter site API secret in %ssettings%s page to enable indexing your content into SearChili.', 'searchili'),
                        '<a href="' . esc_url(admin_url('options-general.php?page=searchili')) . '">', '</a>')
                    . '</p></div>';
            }
		});
		register_activation_hook(__FILE__, function () {
		    SearChili::getInstance()->activation();
		});
	}

	public function admin_ajax_check_save_api_credentials() {
        if (empty($_POST['api_secret'])) {
            wp_send_json(['status' => false, 'message' => __( 'API Secret is not entered!', 'searchili' )]);
        }
        $apiSecret = sanitize_key(trim($_POST['api_secret']));
        if (strlen($apiSecret) !== 36) {
            wp_send_json(['status' => false, 'message' => __( 'API Secret is 32 characters!', 'searchili' )]);
        }
        $this->settings = $this->get_settings(true);
        $this->settings['site_api_secret'] = $apiSecret;
        list($getSiteInfoResponseCode, $getSiteInfoResult) = $this->send_request('GET', 'site');
        if ($getSiteInfoResponseCode == 200 && !empty($getSiteInfoResult->apiKey)) {
            $this->settings['site_api_key'] = sanitize_key(trim($getSiteInfoResult->apiKey));
            $this->settings['get_started_api_finished'] = 'passed';
            update_option('searchili_settings', $this->settings);
            wp_send_json(['status' => true, 'apiKey' => $getSiteInfoResult->apiKey]);
        }
        if ($getSiteInfoResponseCode == 401) {
            wp_send_json(['status' => false, 'message' => __( 'API Secret is not valid!', 'searchili' )]);
        }
        wp_send_json(['status' => false, 'message' => __( 'Request failed. Try again.', 'searchili' )]);
    }

	public function wp_ajax_admin_ajax_index_config() {
        $index_entities_posts = isset($_POST['index_entities_posts']) && $_POST['index_entities_posts'] == 'true';
        $index_entities_pages = isset($_POST['index_entities_pages']) && $_POST['index_entities_pages'] == 'true';
        if (empty($index_entities_posts) && empty($index_entities_pages)) {
            wp_send_json(['status' => false, 'message' => 'At least one of the options must be chosen.']);
        }
        $this->settings = $this->get_settings(true);
        $this->settings['index_entities_posts'] = $index_entities_posts;
        $this->settings['index_entities_pages'] = $index_entities_pages;
        $this->settings['get_started_config_finished'] = 'passed';
        update_option('searchili_settings', $this->settings);
        wp_send_json(['status' => true, 'index_entities_posts' => $this->settings['index_entities_posts'], 'index_entities_pages' => $this->settings['index_entities_pages']]);
    }

	public function wp_ajax_admin_ajax_config_update() {
        if (empty($_POST['search_page_size']) || $_POST['search_page_size'] != (int)$_POST['search_page_size'] || $_POST['search_page_size'] < 1 || $_POST['search_page_size'] > 20) {
            wp_send_json(['status' => false, 'message' => __( 'Search page size must be between 1 to 20', 'searchili' )]);
        }
        if (empty($_POST['sayt_page_size']) || $_POST['sayt_page_size'] != (int)$_POST['sayt_page_size'] || $_POST['sayt_page_size'] < 1 || $_POST['sayt_page_size'] > 10) {
            wp_send_json(['status' => false, 'message' => __( 'SAYT size must be between 1 to 10', 'searchili' )]);
        }
        if (empty($_POST['search_input_selector'])) {
            wp_send_json(['status' => false, 'message' => __( 'Search input selector can not be empty.', 'searchili' )]);
        }
        if (empty($_POST['search_page_id'])) {
            wp_send_json(['status' => false, 'message' => __( 'Search result page is not selected.', 'searchili' )]);
        }
        $searchPageId = (int)sanitize_key(trim($_POST['search_page_id']));
        $possibleSearchPageIDs = array_map(function ($page) {
            return $page->ID;
        }, get_pages(['post_type' => 'page', 'post_status' => 'publish']));
        $possibleSearchPageIDs[] = -1;
        if (!in_array($searchPageId, $possibleSearchPageIDs)) {
            wp_send_json(['status' => false, 'message' => __( 'Search result page is not valid.', 'searchili' )]);
        }
        $this->settings = $this->get_settings(true);
        $this->settings['search_page_size'] = (int)sanitize_key(trim($_POST['search_page_size']));
        $this->settings['sayt_page_size'] = (int)sanitize_key(trim($_POST['sayt_page_size']));
        $this->settings['search_input_selector'] = sanitize_text_field(stripslashes($_POST['search_input_selector']));
        $this->settings['search_page_id'] = $searchPageId;
        update_option('searchili_settings', $this->settings);
        wp_send_json(['status' => true]);
    }

	public function wp_ajax_admin_ajax_create_set_search_page() {
        $this->settings = $this->get_settings(true);
        $this->settings['search_page_id'] = wp_insert_post( [
		    'post_title'   => wp_strip_all_tags( 'Search' ),
		    'post_content' => '[searchili_search_page]',
		    'post_status'  => 'publish',
		    'post_author'  => get_current_user_id(),
		    'post_type'    => 'page',
	    ] );
	    update_option('searchili_settings', $this->settings);
        wp_send_json(['status' => true]);
    }

	public function wp_ajax_admin_ajax_get_list_of_ids_from_searchili() {
        list($allEntitiesResponseCode, $allEntitiesResult) = $this->send_request('GET', 'entity');
        if ($allEntitiesResponseCode == 200) {
            wp_send_json(['status' => true, 'entities' => $allEntitiesResult]);
        }
        wp_send_json(['status' => false, 'payload' => $allEntitiesResult]);
    }

	public function wp_ajax_admin_ajax_get_list_of_content_need_to_be_indexed() {
        $active_post_types = [];
        if (!empty($this->settings['index_entities_posts'])) {
		    $active_post_types[] = 'post';
        }
		if (!empty($this->settings['index_entities_pages'])) {
		    $active_post_types[] = 'page';
		}
        $posts = wp_get_recent_posts([
            'numberposts' => 10000,
	        'post_type' => $active_post_types,
	        'post_status' => 'publish',
	        'orderby' => 'ID',
		    'order' => 'ASC',
        ]);
		$posts = array_map(function ($post) {
		    return (string)$post['ID'];
		}, $posts);
		wp_send_json(['status' => true, 'posts' => $posts]);
    }

	public function wp_ajax_admin_ajax_delete_content_should_not_be_indexed() {
        if (empty($_POST['entityId'])) {
            wp_send_json(['status' => false, 'message' => __( 'EntityID is not entered!', 'searchili' )]);
        }
        $entityId = (int)sanitize_key(trim($_POST['entityId']));
        list($deleteResponseCode, $deleteResult) = $this->send_request('DELETE', 'entity/' . $entityId);
        if ($deleteResponseCode == 200 && !empty($deleteResult->status) && $deleteResult->status === 'deleted') {
            wp_send_json(['status' => true]);
        }
        $message = !empty($putEntityResult->message) ? $putEntityResult->message : '';
        wp_send_json(['status' => false, 'message' => esc_html__( $message, 'searchili' )]);
    }

	public function wp_ajax_admin_ajax_index_missing_content() {
        if (empty($_POST['entityId'])) {
            wp_send_json(['status' => false, 'message' => __( 'EntityID is not entered!', 'searchili' )]);
        }
        $entityId = (int)sanitize_key(trim($_POST['entityId']));
        $post = get_post($entityId);
        if (empty($post)) {
            wp_send_json(['status' => false, 'message' => __( 'Post not found!', 'searchili' )]);
        }

        list($putEntityResponseCode, $putEntityResult) = $this->send_request(
            'PUT',
            'entity/' . $post->ID,
            self::transformPostToEntity($post)
        );
        if ($putEntityResponseCode >= 200 && $putEntityResponseCode <= 299) {
            wp_send_json(['status' => true]);
        }
        $message = !empty($putEntityResult->message) ? $putEntityResult->message : '';
        wp_send_json(['status' => false, 'message' => esc_html__( $message, 'searchili' )]);
    }

	public function activation()
	{
	    $this->settings['index_entities_posts'] = !empty($this->settings['index_entities_posts']) ? $this->settings['index_entities_posts'] : "on";
	    $this->settings['index_entities_pages'] = !empty($this->settings['index_entities_pages']) ? $this->settings['index_entities_pages'] : "on";
	    $this->settings['search_input_selector'] = isset($this->settings['search_input_selector']) ? $this->settings['search_input_selector'] : 'input[name="s"]';
	    $this->settings['search_page_size'] = isset($this->settings['search_page_size']) ? $this->settings['search_page_size'] : 15;
	    $this->settings['sayt_page_size'] = isset($this->settings['sayt_page_size']) ? $this->settings['sayt_page_size'] : 5;
	    update_option('searchili_settings', $this->settings);
	}

    public function client_enqueue_scripts()
    {
        if (empty($this->get_site_api_secret())) {
            return;
        }
        wp_enqueue_script(
            'searchili-settings-js',
            esc_url(self::SEARCHILI_CDN_BASE_URI . 'js/app.js'),
            [],
            SEARCHILI_VERSION,
            true
        );

        $searchPage = $this->get_or_create_search_page();
        $apiKey = $this->get_site_api_key();
        $searchInputSelector = addslashes(!empty($this->settings['search_input_selector']) ? $this->settings['search_input_selector'] : 'input[name="s"]');
	    $searchPageSize = !empty($this->settings['search_page_size']) ? intval($this->settings['search_page_size']) : 15;
	    $saytPageSize = !empty($this->settings['sayt_page_size']) ? intval($this->settings['sayt_page_size']) : 5;
        $isRTL = is_rtl();
	    $phrases = json_encode([
            'powered-by' => __('powered by', 'searchili'),
            'search-powered-by' => __('search powered by', 'searchili'),
            'no-result-message' => __('Couldn\'t find anything related …', 'searchili'),
            'error-message' => __('Oops!<small>Sorry, there\'s some thing wrong. Please try again.</small>', 'searchili'),
            'input-placeholder' => __('Search …', 'searchili'),
            'sayt-init-message' => __('Search …', 'searchili'),
            'form-submit-value' => __('Search', 'searchili'),
            'search-result-result-count' => __('About {totalCount} results ({timeTook} seconds)', 'searchili'),
            'prev' => __('Prev', 'searchili'),
            'next' => __('Next', 'searchili'),
        ]);

        wp_add_inline_script( 'searchili-settings-js', "SearChili.init({apiKey:\"{$apiKey}\", searchPage:\"{$searchPage}\", searchPageSize: \"{$searchPageSize}\", saytPageSize: \"{$saytPageSize}\", searchInputSelector: \"{$searchInputSelector}\", isRTL: $isRTL, phrases: $phrases})");
    }

    public function get_or_create_search_page()
    {
        if (isset($this->settings['search_page_id']) && $this->settings['search_page_id'] > 1) {
	        $search_page = get_post($this->settings['search_page_id']);
	        if (!empty($search_page) && $search_page->post_status === 'publish') {
	            return $search_page->guid;
            } else {
	            $this->settings = $this->get_settings(true);
                $this->settings['search_page_id'] = -1;
                update_option('searchili_settings', $this->settings);
            }
        }
	    return get_site_url();
    }

    private function get_site_api_key()
    {
        return isset($this->settings['site_api_key']) ? $this->settings['site_api_key'] : '';
    }

    private function get_site_api_secret()
    {
        return isset($this->settings['site_api_secret']) ? $this->settings['site_api_secret'] : '';
    }

    private function send_request($method, $endpoint, $data = [])
    {
        $args = [
            'method' => $method,
            'timeout' => '10',
            'redirection' => '5',
            'blocking' => true,
            'headers' => [
                'Accept' => 'application/json',
                'Content-type' => 'application/x-www-form-urlencoded',
                'Authorization' => 'Bearer ' . $this->get_site_api_secret(),
                'user-agent' => 'WordPress/' . get_bloginfo( 'version' ) . ' : ' . SEARCHILI_VERSION . '; ' . get_bloginfo( 'url' ),
            ],
        ];
        if (!empty($data)) {
            $args['body'] = $data;
        }
        $response = @wp_remote_request( self::SEARCHILI_BOB_BASE_URI . $endpoint, $args );
        $responseCode = (int)wp_remote_retrieve_response_code( $response );
        $result = $body = wp_remote_retrieve_body( $response );
        $result = !empty($result) ? json_decode($result) : null;
        $responseHeaders = wp_remote_retrieve_headers( $response );
        return [$responseCode, $result, $responseHeaders];
    }

    public function i18n()
    {
        load_plugin_textdomain('searchili', false, SEARCHILI_DIR . '/languages/' );
    }

    public function default_search_page()
    {
        if ( (!isset($this->settings['search_page_id']) || $this->settings['search_page_id'] == -1) && !empty( $_GET['searchili-query'] ) ) {
            require_once SEARCHILI_DIR . '/templates/client_default_search_page.php';
            // In our template we add header and footer ourselves,
            // so we need to stop execution here to avoid re-rendering
            // them after our footer.
            die();
        }
    }

    public function admin_searchili_indexing_options_page()
    {
        wp_enqueue_style('searchili-css-roboto-font', 'https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons', [], SEARCHILI_VERSION);
        wp_enqueue_style('searchili-css-material-dashboard', SEARCHILI_URL . 'assets/css/material-dashboard.css', [], SEARCHILI_VERSION);
        wp_enqueue_style('searchili-css-material-dashboard-rtl', SEARCHILI_URL . 'assets/css/material-dashboard-rtl.css', [], SEARCHILI_VERSION);
        return require_once SEARCHILI_DIR . '/templates/admin_index.php';
    }

    public function admin_searchili_options_page()
    {
        wp_enqueue_style('searchili-css-roboto-font', 'https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons', [], SEARCHILI_VERSION);
        wp_enqueue_style('searchili-css-material-dashboard', SEARCHILI_URL . 'assets/css/material-dashboard.css', [], SEARCHILI_VERSION);
        wp_enqueue_style('searchili-css-material-dashboard-rtl', SEARCHILI_URL . 'assets/css/material-dashboard-rtl.css', [], SEARCHILI_VERSION);

        list($getSiteInfoResponseCode, $siteInfo) = $this->send_request('GET', 'site');
        if ($getSiteInfoResponseCode === 401) {
            $this->settings = $this->get_settings(true);
            unset($this->settings['site_api_secret'], $this->settings['get_started_config_finished']);
            update_option('searchili_settings', $this->settings);
        }
        if (!empty($siteInfo->apiKey) && $siteInfo->apiKey != $this->get_site_api_key()) {
            $this->settings = $this->get_settings(true);
            $this->settings['site_api_key'] = $siteInfo->apiKey;
            update_option('searchili_settings', $this->settings);
        }
        if (empty($this->settings['get_started_api_finished']) || empty($this->get_site_api_secret()) || isset($_GET['changeAPI'])) {
            return require_once SEARCHILI_DIR . '/templates/admin_get_started_api.php';
        }
        if (empty($this->settings['get_started_config_finished']) || isset($_GET['indexConfig'])) {
            return require_once SEARCHILI_DIR . '/templates/admin_get_started_index_config.php';
        }
        return require_once SEARCHILI_DIR . '/templates/admin_dashboard.php';
    }

    /**
    * @param int $postId
    * @param WP_Post $post
    * @param bool $update
    * @return void|bool
    */
    public function admin_save_post_hook($postId, $post, $update)
    {
        if (empty($this->get_site_api_secret())) {
            return true;
        }
        $active_post_types = [];
        if (!empty($this->settings['index_entities_posts'])) {
            $active_post_types[] = 'post';
        }
        if (!empty($this->settings['index_entities_pages'])) {
            $active_post_types[] = 'page';
        }
        if (!in_array($post->post_type, $active_post_types)) {
            return true;
        }
        try {
            if ($post->post_status === 'publish') {
                list($putEntityResponseCode) = $this->send_request(
                    'PUT',
                    'entity/' . $postId,
                    self::transformPostToEntity($post)
                );
                if ($putEntityResponseCode >= 200 && $putEntityResponseCode <= 299) {
                    return true;
                }
            } else {
                list($putEntityResponseCode) = $this->send_request('DELETE', 'entity/' . $postId);
                if ($putEntityResponseCode == 200) {
                    return true;
                }
            }
        } catch (\Exception $exception) {}
        return false;
    }

    public static function transformPostToEntity($post)
    {
        return [
            'id' => (string)$post->ID,
            'title' => !empty($post->post_title) ? $post->post_title : '',
            'link' => get_permalink($post->ID),
            'excerpt' => !empty($post->post_excerpt) ? $post->post_excerpt : null,
            'body' => !empty($post->post_content) ? $post->post_content : null,
            'image' => !empty($thumbnail = get_the_post_thumbnail_url($post->ID)) ? $thumbnail : null,
            'categories' => array_map(function ($catId) {
                $category = get_category($catId);
                return !empty($category->name) ? $category->name : null;
            }, wp_get_post_categories($post->ID)),
            'tags' => array_map(function ($term) {
                return !empty($term->name) ? $term->name : null;
            }, wp_get_post_tags($post->ID)),
            'publishedAt' => !empty($post->post_date_gmt) ? $post->post_date_gmt : null,
        ];
    }
}

SearChili::getInstance();
