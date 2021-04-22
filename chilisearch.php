<?php
/**
 * WP Chili Search.
 *
 * WP Chili Search plugin file.
 *
 * @package           ChiliSearch
 * @author            Ali Jafari <ali@chilisearch.com>
 * @copyright         Copyright (C) 2021, Chili Search - info@chilisearch.com
 *
 * @wordpress-plugin
 * Plugin Name:       Chili Search
 * Plugin URI:        https://chilisearch.com
 * Description:       Power up discovery of Posts, Pages, Media, WooCommerce and bbPress using our AI-Powered Search Engine.
 * Version:           2.0.3
 * Author:            ChiliSearch
 * Author URI:        https://chilisearch.com/
 * License:           GPLv2 or later
 * Text Domain:       chilisearch
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

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

define( 'CHILISEARCH_VERSION', '2.0.3' );
define( 'CHILISEARCH_DIR', __DIR__ );
define( 'CHILISEARCH_PHP_MINIMUM', '5.6.0' );
define(
    'CHILISEARCH_URL',
    strpos( home_url( '/' ), 'https://' ) !== false || strpos( plugin_dir_url( __FILE__ ), 'https://' ) !== false ?
        str_replace( 'http://', 'https://', plugin_dir_url( __FILE__ ) ) : plugin_dir_url( __FILE__ )
);

require_once CHILISEARCH_DIR . '/widgets/class-widget-search.php';

final class ChiliSearch {
    const CHILISEARCH_BOB_BASE_URI = 'https://api.chilisearch.com/bob/v1/';
    const CHILISEARCH_CDN_BASE_URI = 'https://cdn.chilisearch.com/alice/v1/';
    const CHILISEARCH_APP_BASE_URI = 'https://app.chilisearch.com/';

    const MIME_TYPES_DOCS = [
        'application/msword'                                                        => 'doc',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document'   => 'docx',
        'application/vnd.openxmlformats-officedocument.presentationml.presentation' => 'pptx',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'         => 'xlsx',
        'application/pdf'                                                           => 'pdf',
        'text/html'                                                                 => 'html',
        'application/vnd.oasis.opendocument.text'                                   => 'odt',
        'text/plain'                                                                => 'txt',
    ];
    const MIME_TYPES_IMAGES = [
        'image/jpeg'   => 'jpg',
        'image/png'    => 'png',
        'image/gif'    => 'gif',
        'image/x-icon' => 'ico',
    ];
    const WP_POST_TYPE_POST = 'post';
    const WP_POST_TYPE_PAGE = 'page';
    const WP_POST_TYPE_ATTACHMENT = 'attachment';
    const WP_POST_TYPE_PRODUCT = 'product';
    const WP_POST_TYPE_FORUM_FORUM = 'forum';
    const WP_POST_TYPE_FORUM_TOPIC = 'topic';
    const WP_POST_TYPE_FORUM_REPLY = 'reply';
    const WP_POST_TYPES = [
        self::WP_POST_TYPE_POST,
        self::WP_POST_TYPE_PAGE,
        self::WP_POST_TYPE_ATTACHMENT,
        self::WP_POST_TYPE_PRODUCT,
        self::WP_POST_TYPE_FORUM_FORUM,
        self::WP_POST_TYPE_FORUM_TOPIC,
        self::WP_POST_TYPE_FORUM_REPLY,
    ];
    const SEARCH_WORD_TYPE_BOTH = 'both';
    const SEARCH_WORD_TYPE_WHOLE_WORD = 'whole_word';
    const SEARCH_WORD_TYPE_PARTIAL_WORD = 'partial_word';

    const SORT_BY_RELEVANCY = 'relevancy';
    const SORT_BY_PUBLISHED_AT_DESC = 'publishedat-desc';
    const SORT_BY_PUBLISHED_AT_ASC = 'publishedat-asc';
    const SORT_BY_PRICE_DESC = 'price-desc';
    const SORT_BY_PRICE_ASC = 'price-asc';
    const SORT_BYS = [
        self::SORT_BY_RELEVANCY         => '_score',
        self::SORT_BY_PUBLISHED_AT_DESC => '-publishedAt',
        self::SORT_BY_PUBLISHED_AT_ASC  => '+publishedAt',
        self::SORT_BY_PRICE_DESC        => '+price',
        self::SORT_BY_PRICE_ASC         => '-price',
    ];

    private static $instance = null;

    private $settings = [
        'search_page_id'               => - 1,
        'search_page_size'             => 15,
        'sayt_page_size'               => 5,
        'search_word_type'             => self::SEARCH_WORD_TYPE_BOTH,
        'sort_by'                      => self::SORT_BY_RELEVANCY,
        'display_result_image'         => true,
        'display_result_product_price' => false,
        'display_result_excerpt'       => true,
        'display_result_categories'    => true,
        'display_result_tags'          => true,
        'display_chilisearch_brand'    => true,
        'weight_title'                 => 3,
        'weight_excerpt'               => 2,
        'weight_body'                  => 1,
        'weight_tags'                  => 5,
        'weight_categories'            => 3,
        'filter_type'                  => true,
        'filter_category'              => true,
        'filter_publishedat'           => true,
        'filter_price'                 => false,
        'auto_search_detection'        => true,
        'search_input_selector'        => 'input[name="s"]',
    ];
    private $wts_settings = [
        'posts'                                  => true,
        'posts_approved_comments'                => false,
        'pages'                                  => true,
        'pages_approved_comments'                => false,
        'media'                                  => false,
        'media_doc_files'                        => false,
        'media_approved_comments'                => false,
        'woocommerce_products'                   => false,
        'woocommerce_products_approved_comments' => false,
        'woocommerce_products_outofstock'        => false,
        'woocommerce_products_sku'               => false,
        'bbpress_forum'                          => false,
        'bbpress_topic'                          => false,
        'bbpress_reply'                          => false,
    ];
    private $configs = [
        'site_api_key'                => null,
        'site_api_secret'             => null,
        'get_started_api_finished'    => false,
        'get_started_config_finished' => false,
        'website_info'                => null,
    ];

    private function __construct() {
        if ( version_compare( PHP_VERSION, CHILISEARCH_PHP_MINIMUM, '<' ) ) {
            wp_die(
                esc_html( sprintf( __( 'Chili Search requires PHP version %s', 'chilisearch' ), CHILISEARCH_PHP_MINIMUM ) ),
                esc_html__( 'Error Activating', 'chilisearch' )
            );
        }

        $this->get_settings();
        $this->get_wts_settings();
        $this->get_configs();

        $this->setup_client_actions();
        $this->setup_admin_actions();
    }

    public static function getInstance() {
        if ( is_null( self::$instance ) ) {
            self::$instance = new ChiliSearch();
        }

        return self::$instance;
    }

    public static function get_word_types() {
        return [
            self::SEARCH_WORD_TYPE_WHOLE_WORD   => __( 'Whole Word', 'chilisearch' ),
            self::SEARCH_WORD_TYPE_PARTIAL_WORD => __( 'Partial Word', 'chilisearch' ),
            self::SEARCH_WORD_TYPE_BOTH         => __( 'Both', 'chilisearch' ),
        ];
    }

    public static function get_sort_bys() {
        return [
            self::SORT_BY_RELEVANCY         => __( 'Relevancy', 'chilisearch' ),
            self::SORT_BY_PUBLISHED_AT_DESC => __( 'PublishedAt DESC', 'chilisearch' ),
            self::SORT_BY_PUBLISHED_AT_ASC  => __( 'PublishedAt ASC', 'chilisearch' ),
            self::SORT_BY_PRICE_DESC        => __( 'Price DESC', 'chilisearch' ),
            self::SORT_BY_PRICE_ASC         => __( 'Price ASC', 'chilisearch' ),
        ];
    }

    private function get_settings() {
        $settings = get_option( 'chilisearch_settings' );
        if ( ! empty( $settings ) ) {
            $this->settings = array_merge( $this->settings, $settings );
        }

        return $this->settings;
    }

    private function get_wts_settings() {
        $wts_settings = get_option( 'chilisearch_wts_settings' );
        if ( ! empty( $wts_settings ) ) {
            $this->wts_settings = array_merge( $this->wts_settings, $wts_settings );
        }

        return $this->wts_settings;
    }

    private function get_configs() {
        $configs = get_option( 'chilisearch_configs' );
        if ( ! empty( $configs ) ) {
            $this->configs = array_merge( $this->configs, $configs );
        }

        return $this->configs;
    }

    private function setup_client_actions() {
        add_action( 'plugins_loaded', [ $this, 'i18n' ], 2 );
        add_action( 'wp', [ $this, 'default_search_page' ] );
        add_action( 'wp_enqueue_scripts', [ $this, 'client_enqueue_scripts' ] );
        add_shortcode( 'chilisearch_search_page', function () {
            return '<div id="chilisearch-search_page"></div>';
        } );
        add_action( 'widgets_init', function () {
            register_widget( 'Widget_Search' );
        } );
    }

    private function setup_admin_actions() {
        add_action( 'save_post', [ $this, 'admin_save_post_hook' ], 10, 3 );
        if ( ! is_admin() ) {
            return;
        }
        add_action( 'wp_ajax_admin_ajax_register_website', [ $this, 'admin_ajax_register_website' ] );
        add_action( 'wp_ajax_admin_ajax_index_config', [ $this, 'wp_ajax_admin_ajax_index_config' ] );
        add_action( 'wp_ajax_admin_ajax_config_update', [ $this, 'wp_ajax_admin_ajax_config_update' ] );
        add_action( 'wp_ajax_admin_ajax_create_set_search_page', [ $this, 'wp_ajax_admin_ajax_create_set_search_page' ] );
        add_action( 'wp_ajax_admin_ajax_get_list_of_ids_from_chilisearch', [ $this, 'wp_ajax_admin_ajax_get_list_of_ids_from_chilisearch' ] );
        add_action( 'wp_ajax_admin_ajax_get_list_of_content_need_to_be_indexed', [ $this, 'wp_ajax_admin_ajax_get_list_of_content_need_to_be_indexed' ] );
        add_action( 'wp_ajax_admin_ajax_delete_content_should_not_be_indexed', [ $this, 'wp_ajax_admin_ajax_delete_content_should_not_be_indexed' ] );
        add_action( 'wp_ajax_admin_ajax_index_missing_content', [ $this, 'wp_ajax_admin_ajax_index_missing_content' ] );
        add_action( 'wp_ajax_admin_ajax_get_posts_count', [ $this, 'wp_ajax_admin_ajax_get_posts_count' ] );
        add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), function ( $links ) {
            array_unshift( $links, sprintf(
                '<a href="%s">%s</a>',
                esc_url( add_query_arg( array( 'page' => 'chilisearch' ), admin_url( 'admin.php' ) ) ),
                __( 'Settings', 'chilisearch' )
            ) );
            return $links;
        } );
        add_action( 'admin_menu', function () {
            add_menu_page(
                __( 'Chili Search Settings', 'chilisearch' ),
                __( 'Chili Search', 'chilisearch' ),
                apply_filters( 'chilisearch_settings_capability', 'manage_options' ),
                'chilisearch',
                [ $this, 'admin_chilisearch_options_page' ],
                CHILISEARCH_URL . 'icon.png'
            );
            add_submenu_page(
                'chilisearch',
                __( 'Chili Search Settings', 'chilisearch' ),
                __( 'Settings', 'chilisearch' ),
                'manage_options',
                'chilisearch',
                [ $this, 'admin_chilisearch_options_page' ]
            );
        } );
        add_action( 'admin_init', function () {
            register_setting( 'chilisearch_settings_group', 'chilisearch_settings' );
        } );
        add_action( 'admin_notices', function () {
            if ( empty( $this->configs['site_api_secret'] ) && ( ! isset( $_GET['page'] ) || $_GET['page'] !== 'chilisearch' ) ) {
                echo '<div class="notice notice-warning is-dismissible"><p>
                         <strong>' . __( 'Chili Search Setup', 'chilisearch' ) . '</strong><br>'
                     . sprintf( __( 'Setup your Chili Search %shere%s to empower your website\'s search!', 'chilisearch' ),
                        '<a href="' . esc_url( admin_url( 'admin.php?page=chilisearch' ) ) . '">', '</a>' )
                     . '</p></div>';
            }
        } );
        add_action( 'init', function () {
            ob_start();
        } );
        register_activation_hook( __FILE__, function () {
            ChiliSearch::getInstance()->activation();
        } );
    }

    public function activation() {
    }

    public function admin_ajax_register_website() {
        list( $getSiteInfoResponseCode, $getSiteInfoResult ) = $this->send_request( 'PUT', 'website', [
            'name'     => get_bloginfo( 'name' ),
            'email'    => get_bloginfo( 'admin_email' ),
            'url'      => get_bloginfo( 'wpurl' ),
            'language' => get_bloginfo( 'language' ),
        ] );
        if ( $getSiteInfoResponseCode == 201 && ! empty( $getSiteInfoResult->apiSecret ) && ! empty( $getSiteInfoResult->apiKey ) ) {
            $this->get_configs();
            $this->configs['site_api_secret']          = sanitize_key( trim( $getSiteInfoResult->apiSecret ) );
            $this->configs['site_api_key']             = sanitize_key( trim( $getSiteInfoResult->apiKey ) );
            $this->configs['get_started_api_finished'] = true;
            $this->set_configs();
            wp_send_json( [ 'status' => true, 'apiKey' => $getSiteInfoResult->apiKey ] );
        }
        if ( $getSiteInfoResponseCode == 401 ) {
            wp_send_json( [ 'status' => false, 'message' => __( 'API Secret is not valid!', 'chilisearch' ) ] );
        }
        wp_send_json( [ 'status' => false, 'message' => __( 'Request failed. Try again.', 'chilisearch' ) ] );
    }

    private function send_request( $method, $endpoint, $data = [] ) {
        $args = [
            'method'      => $method,
            'timeout'     => '10',
            'redirection' => '5',
            'blocking'    => true,
            'headers'     => [
                'Accept'       => 'application/json',
                'Content-type' => 'application/x-www-form-urlencoded',
                'user-agent'   => 'WordPress/' . get_bloginfo( 'version' ) . ' : ' . CHILISEARCH_VERSION . ' ; ' . get_bloginfo( 'url' ),
            ],
        ];
        if ( ! empty( $this->configs['site_api_secret'] ) ) {
            $args['headers']['Authorization'] = 'Bearer ' . $this->configs['site_api_secret'];
        }
        if ( ! empty( $data ) ) {
            $args['body'] = $data;
        }
        $response        = @wp_remote_request( self::CHILISEARCH_BOB_BASE_URI . $endpoint, $args );
        $responseCode    = (int) wp_remote_retrieve_response_code( $response );
        $result          = $body = wp_remote_retrieve_body( $response );
        $result          = ! empty( $result ) ? json_decode( $result ) : null;
        $responseHeaders = wp_remote_retrieve_headers( $response );

        return [ $responseCode, $result, $responseHeaders ];
    }

    private function set_settings() {
        if ( function_exists( 'is_plugin_active' ) ) {
            $this->settings['display_result_product_price'] = $this->settings['display_result_product_price'] && $this->is_woocommerce_active();
            $this->settings['filter_price']                 = $this->settings['filter_price'] && $this->is_woocommerce_active();
        }
        $this->settings['sort_by']                      = $this->get_current_plan() === 'premium' ? $this->settings['sort_by'] : self::SORT_BYS[ self::SORT_BY_RELEVANCY ];
        $this->settings['display_result_product_price'] = $this->get_current_plan() === 'premium' && $this->settings['display_result_product_price'];
        $this->settings['display_chilisearch_brand']    = $this->get_current_plan() !== 'premium' || $this->settings['display_chilisearch_brand'];
        update_option( 'chilisearch_settings', $this->settings );
    }

    private function set_wts_settings() {
        if ( function_exists( 'is_plugin_active' ) ) {
            $this->wts_settings['woocommerce_products']                   = $this->wts_settings['woocommerce_products'] && $this->is_woocommerce_active();
            $this->wts_settings['woocommerce_products_approved_comments'] = $this->wts_settings['woocommerce_products_approved_comments'] && $this->is_woocommerce_active();
            $this->wts_settings['woocommerce_products_outofstock']        = $this->wts_settings['woocommerce_products_outofstock'] && $this->is_woocommerce_active();
            $this->wts_settings['woocommerce_products_sku']               = $this->wts_settings['woocommerce_products_sku'] && $this->is_woocommerce_active();
            $this->wts_settings['bbpress_forum']                          = $this->wts_settings['bbpress_forum'] && $this->is_bbpress_active();
            $this->wts_settings['bbpress_topic']                          = $this->wts_settings['bbpress_topic'] && $this->is_bbpress_active();
            $this->wts_settings['bbpress_reply']                          = $this->wts_settings['bbpress_reply'] && $this->is_bbpress_active();
        }
        if ( $this->get_current_plan() !== 'premium' ) {
            $this->wts_settings['woocommerce_products_approved_comments'] = false;
            $this->wts_settings['woocommerce_products_sku']               = false;
            $this->wts_settings['posts_approved_comments']                = false;
            $this->wts_settings['pages_approved_comments']                = false;
            $this->wts_settings['media']                                  = false;
            $this->wts_settings['media_approved_comments']                = false;
            $this->wts_settings['media_doc_files']                        = false;
        }
        update_option( 'chilisearch_wts_settings', $this->wts_settings );
    }

    private function set_configs() {
        update_option( 'chilisearch_configs', $this->configs );
    }

    public function wp_ajax_admin_ajax_index_config() {
        $posts                                  = isset( $_POST['posts'] ) && $_POST['posts'] == 'true';
        $posts_approved_comments                = isset( $_POST['posts_approved_comments'] ) && $_POST['posts_approved_comments'] == 'true';
        $pages                                  = isset( $_POST['pages'] ) && $_POST['pages'] == 'true';
        $pages_approved_comments                = isset( $_POST['pages_approved_comments'] ) && $_POST['pages_approved_comments'] == 'true';
        $media                                  = isset( $_POST['media'] ) && $_POST['media'] == 'true';
        $media_approved_comments                = isset( $_POST['media_approved_comments'] ) && $_POST['media_approved_comments'] == 'true';
        $woocommerce_products                   = isset( $_POST['woocommerce_products'] ) && $_POST['woocommerce_products'] == 'true';
        $woocommerce_products_approved_comments = isset( $_POST['woocommerce_products_approved_comments'] ) && $_POST['woocommerce_products_approved_comments'] == 'true';
        $woocommerce_products_outofstock        = isset( $_POST['woocommerce_products_outofstock'] ) && $_POST['woocommerce_products_outofstock'] == 'true';
        $woocommerce_products_sku               = isset( $_POST['woocommerce_products_sku'] ) && $_POST['woocommerce_products_sku'] == 'true';
        $bbpress_forum                          = isset( $_POST['bbpress_forum'] ) && $_POST['bbpress_forum'] == 'true';
        $bbpress_topic                          = isset( $_POST['bbpress_topic'] ) && $_POST['bbpress_topic'] == 'true';
        $bbpress_reply                          = isset( $_POST['bbpress_reply'] ) && $_POST['bbpress_reply'] == 'true';
        $media_doc_files                        = isset( $_POST['media_doc_files'] ) && $_POST['media_doc_files'] == 'true';
        if ( ! ( $posts || $pages || $media || $woocommerce_products || $bbpress_forum ) ) {
            wp_send_json( [ 'status' => false, 'message' => __( 'Choose at least one option.' ) ] );
        }
        $this->get_wts_settings();
        $this->wts_settings['posts']                                  = $posts;
        $this->wts_settings['posts_approved_comments']                = $posts_approved_comments;
        $this->wts_settings['pages']                                  = $pages;
        $this->wts_settings['pages_approved_comments']                = $pages_approved_comments;
        $this->wts_settings['media']                                  = $media;
        $this->wts_settings['media_doc_files']                        = $media_doc_files;
        $this->wts_settings['media_approved_comments']                = $media_approved_comments;
        $this->wts_settings['woocommerce_products']                   = $woocommerce_products;
        $this->wts_settings['woocommerce_products_approved_comments'] = $woocommerce_products_approved_comments;
        $this->wts_settings['woocommerce_products_outofstock']        = $woocommerce_products_outofstock;
        $this->wts_settings['woocommerce_products_sku']               = $woocommerce_products_sku;
        $this->wts_settings['bbpress_forum']                          = $bbpress_forum;
        $this->wts_settings['bbpress_topic']                          = $bbpress_topic;
        $this->wts_settings['bbpress_reply']                          = $bbpress_reply;
        $this->set_wts_settings();
        if ( empty( $this->configs['get_started_config_finished'] ) ) {
            $this->get_configs();
            $this->configs['get_started_config_finished'] = true;
            $this->set_configs();
        }
        wp_send_json( [ 'status' => true ] );
    }

    protected function is_woocommerce_active() {
        return class_exists('WooCommerce');
    }

    protected function is_bbpress_active() {
        return class_exists( 'bbPress' );
    }

    public function wp_ajax_admin_ajax_config_update() {
        if ( empty( $_POST['search_page_size'] ) || $_POST['search_page_size'] != (int) $_POST['search_page_size'] || $_POST['search_page_size'] < 1 || $_POST['search_page_size'] > 20 ) {
            wp_send_json( [ 'status'  => false, 'message' => __( 'Search page size must be between 1 to 20', 'chilisearch' ) ] );
        }
        if ( empty( $_POST['sayt_page_size'] ) || $_POST['sayt_page_size'] != (int) $_POST['sayt_page_size'] || $_POST['sayt_page_size'] < 1 || $_POST['sayt_page_size'] > 10 ) {
            wp_send_json( [ 'status'  => false, 'message' => __( 'SAYT size must be between 1 to 10', 'chilisearch' ) ] );
        }
        if ( empty( $_POST['search_input_selector'] ) ) {
            wp_send_json( [ 'status'  => false, 'message' => __( 'Search input selector can not be empty.', 'chilisearch' ) ] );
        }
        if ( empty( $_POST['search_page_id'] ) ) {
            wp_send_json( [ 'status'  => false, 'message' => __( 'Search result page is not selected.', 'chilisearch' ) ] );
        }
        if ( !isset( $_POST['weight_title'] ) ) {
            wp_send_json( [ 'status'  => false, 'message' => __( 'Weight for title is not selected.', 'chilisearch' ) ] );
        }
        if ( !isset( $_POST['weight_excerpt'] ) ) {
            wp_send_json( [ 'status'  => false, 'message' => __( 'Weight for excerpt is not selected.', 'chilisearch' ) ] );
        }
        if ( !isset( $_POST['weight_body'] ) ) {
            wp_send_json( [ 'status'  => false, 'message' => __( 'Weight for body is not selected.', 'chilisearch' ) ] );
        }
        if ( !isset( $_POST['weight_tags'] ) ) {
            wp_send_json( [ 'status'  => false, 'message' => __( 'Weight for tags is not selected.', 'chilisearch' ) ] );
        }
        if ( !isset( $_POST['weight_categories'] ) ) {
            wp_send_json( [ 'status'  => false, 'message' => __( 'Weight for category is not selected.', 'chilisearch' ) ] );
        }
        $word_types = self::get_word_types();
        if ( empty( $_POST['search_word_type'] ) || ! isset( $word_types[ $_POST['search_word_type'] ] ) ) {
            wp_send_json( [ 'status' => false, 'message' => __( 'Search type is invalid.', 'chilisearch' ) ] );
        }
        $sort_bys = self::get_sort_bys();
        if ( empty( $_POST['sort_by'] ) || ! isset( $sort_bys[ $_POST['sort_by'] ] ) ) {
            wp_send_json( [ 'status' => false, 'message' => __( 'Sort by is invalid.', 'chilisearch' ) ] );
        }
        $searchPageId            = (int) sanitize_key( trim( $_POST['search_page_id'] ) );
        $possibleSearchPageIDs   = array_map( function ( $page ) {
            return $page->ID;
        }, get_pages( [ 'post_type' => self::WP_POST_TYPE_PAGE, 'post_status' => 'publish' ] ) );
        $possibleSearchPageIDs[] = - 1;
        if ( ! in_array( $searchPageId, $possibleSearchPageIDs ) ) {
            wp_send_json( [ 'status' => false, 'message' => __( 'Search result page is not valid.', 'chilisearch' ) ] );
        }
        $this->get_settings();
        $this->settings['search_page_size']             = (int) sanitize_key( trim( $_POST['search_page_size'] ) );
        $this->settings['sayt_page_size']               = (int) sanitize_key( trim( $_POST['sayt_page_size'] ) );
        $this->settings['auto_search_detection']        = isset( $_POST['auto_search_detection'] ) && $_POST['auto_search_detection'] == 'true';
        $this->settings['search_input_selector']        = sanitize_text_field( stripslashes( $_POST['search_input_selector'] ) );
        $this->settings['search_page_id']               = $searchPageId;
        $this->settings['search_word_type']             = sanitize_key( trim( $_POST['search_word_type'] ) );
        $this->settings['display_result_image']         = isset( $_POST['display_result_image'] ) && $_POST['display_result_image'] == 'true';
        $this->settings['filter_type']                  = isset( $_POST['filter_type'] ) && $_POST['filter_type'] == 'true';
        $this->settings['filter_category']              = isset( $_POST['filter_category'] ) && $_POST['filter_category'] == 'true';
        $this->settings['filter_publishedat']           = isset( $_POST['filter_publishedat'] ) && $_POST['filter_publishedat'] == 'true';
        $this->settings['filter_price']                 = isset( $_POST['filter_price'] ) && $_POST['filter_price'] == 'true';
        $this->settings['display_result_excerpt']       = isset( $_POST['display_result_excerpt'] ) && $_POST['display_result_excerpt'] == 'true';
        $this->settings['display_result_categories']    = isset( $_POST['display_result_categories'] ) && $_POST['display_result_categories'] == 'true';
        $this->settings['display_result_tags']          = isset( $_POST['display_result_tags'] ) && $_POST['display_result_tags'] == 'true';
        if ($this->get_current_plan() === 'premium') {
            $this->settings['sort_by']                      = sanitize_key( trim( $_POST['sort_by'] ) );
            $this->settings['weight_title']                 = (int) sanitize_key( trim( $_POST['weight_title'] ) );
            $this->settings['weight_excerpt']               = (int) sanitize_key( trim( $_POST['weight_excerpt'] ) );
            $this->settings['weight_body']                  = (int) sanitize_key( trim( $_POST['weight_body'] ) );
            $this->settings['weight_tags']                  = (int) sanitize_key( trim( $_POST['weight_tags'] ) );
            $this->settings['weight_categories']            = (int) sanitize_key( trim( $_POST['weight_categories'] ) );
            $this->settings['display_result_product_price'] = isset( $_POST['display_result_product_price'] ) && $_POST['display_result_product_price'] == 'true';
            $this->settings['display_chilisearch_brand']    = isset( $_POST['display_chilisearch_brand'] ) && $_POST['display_chilisearch_brand'] == 'true';
        }
        $this->set_settings();
        wp_send_json( [ 'status' => true ] );
    }

    public function wp_ajax_admin_ajax_create_set_search_page() {
        $this->get_settings();
        $this->settings['search_page_id'] = wp_insert_post( [
            'post_title'   => wp_strip_all_tags( __( 'Search' ) ),
            'post_content' => '[chilisearch_search_page]',
            'post_status'  => 'publish',
            'post_author'  => get_current_user_id(),
            'post_type'    => self::WP_POST_TYPE_PAGE,
        ] );
        $this->set_settings();
        wp_send_json( [ 'status' => true ] );
    }

    public function wp_ajax_admin_ajax_get_list_of_ids_from_chilisearch() {
        list( $allDocumentsResponseCode, $allDocumentsResult ) = $this->send_request( 'GET', 'documents' );
        if ( $allDocumentsResponseCode == 200 ) {
            wp_send_json( [ 'status' => true, 'documents' => $allDocumentsResult ] );
        }
        wp_send_json( [ 'status' => false, 'payload' => $allDocumentsResult ] );
    }

    public function wp_ajax_admin_ajax_get_list_of_content_need_to_be_indexed() {
        $active_post_types = $this->get_active_post_types();
        $posts             = $this->admin_get_active_posts( $active_post_types );
        $posts             = array_filter( $posts, function ( $post ) {
            if ( $post->post_type === self::WP_POST_TYPE_PRODUCT && ! $this->wts_settings['woocommerce_products_outofstock'] ) {
                $product = wc_get_product( $post->ID );

                return $product->get_stock_status() === 'instock';
            }

            return true;
        } );
        $documentIDs       = array_map( [ $this, 'get_document_id_from_post' ], $posts );

        wp_send_json( [ 'status' => true, 'documents' => array_values( $documentIDs ) ] );
    }

    protected function get_active_post_types() {
        $active_post_types = [];
        if ( ! empty( $this->wts_settings['posts'] ) ) {
            $active_post_types[] = self::WP_POST_TYPE_POST;
        }
        if ( ! empty( $this->wts_settings['pages'] ) ) {
            $active_post_types[] = self::WP_POST_TYPE_PAGE;
        }
        if ( ! empty( $this->wts_settings['media'] ) ) {
            $active_post_types[] = self::WP_POST_TYPE_ATTACHMENT;
        }
        if ( ! empty( $this->wts_settings['woocommerce_products'] ) ) {
            $active_post_types[] = self::WP_POST_TYPE_PRODUCT;
        }
        if ( ! empty( $this->wts_settings['bbpress_forum'] ) ) {
            $active_post_types[] = self::WP_POST_TYPE_FORUM_FORUM;
            if ( ! empty( $this->wts_settings['bbpress_topic'] ) ) {
                $active_post_types[] = self::WP_POST_TYPE_FORUM_TOPIC;
            }
            if ( ! empty( $this->wts_settings['bbpress_reply'] ) ) {
                $active_post_types[] = self::WP_POST_TYPE_FORUM_REPLY;
            }
        }

        return $active_post_types;
    }

    protected function admin_get_active_posts( $active_post_types ) {
        $query = new WP_Query( [
            'post_type'      => $active_post_types,
            'post_status'    => 'inherit,publish',
            'posts_per_page' => - 1,
            'orderby'        => 'ID',
            'order'          => 'ASC',
        ] );

        return array_filter( $query->posts, function ( $post ) {
            if ( $post->post_status === 'inherit' ) {
                $post_parent = get_post( $post->post_parent );
                if ( $post_parent === null || $post_parent->post_status !== 'publish' ) {
                    return false;
                }
            }

            return true;
        } );
    }

    public function wp_ajax_admin_ajax_delete_content_should_not_be_indexed() {
        if ( empty( $_POST['documentId'] ) ) {
            wp_send_json( [ 'status' => false, 'message' => __( 'DocumentId is not entered!', 'chilisearch' ) ] );
        }
        $documentId = sanitize_key( trim( $_POST['documentId'] ) );
        list( $deleteResponseCode, $deleteResult ) = $this->send_request( 'DELETE', 'documents/' . $documentId );
        if ( $deleteResponseCode == 200 && ! empty( $deleteResult->status ) && $deleteResult->status === 'deleted' ) {
            wp_send_json( [ 'status' => true ] );
        }
        $message = ! empty( $putDocumentResult->message ) ? $putDocumentResult->message : '';
        wp_send_json( [ 'status' => false, 'message' => esc_html__( $message, 'chilisearch' ) ] );
    }

    public function wp_ajax_admin_ajax_index_missing_content() {
        if ( empty( $_POST['documentId'] ) ) {
            wp_send_json( [ 'status' => false, 'message' => __( 'DocumentId is not entered!', 'chilisearch' ) ] );
        }
        list( $documentType, $documentId ) = explode( '-', sanitize_key( trim( $_POST['documentId'] ) ) );
        $post = get_post( (int) $documentId );
        if ( empty( $post ) ) {
            wp_send_json( [ 'status' => false, 'message' => __( 'Post not found!', 'chilisearch' ) ] );
        }
        $document = $this->transform_post_to_document( $post );
        if ( empty( $document ) ) {
            wp_send_json( [ 'status' => false, 'message' => __( 'Document type is invalid.', 'chilisearch' ) ] );
        }

        list( $putDocumentResponseCode, $putDocumentResult ) = $this->send_request(
            'PUT',
            'documents',
            $document
        );
        if ( $putDocumentResponseCode === 200 || $putDocumentResponseCode === 201 ) {
            wp_send_json( [ 'status' => true ] );
        }
        $message = ! empty( $putDocumentResult->message ) ? $putDocumentResult->message : '';
        wp_send_json( [ 'status' => false, 'message' => esc_html__( $message, 'chilisearch' ) ] );
    }

    public function transform_post_to_document( $post ) {
        $document = [
            'id'          => $this->get_document_id_from_post( $post ),
            'type'        => $post->post_type,
            'title'       => ! empty( $post->post_title ) ? $post->post_title : '',
            'link'        => get_permalink( $post->ID ),
            'excerpt'     => ! empty( $post->post_excerpt ) ? $post->post_excerpt : null,
            'body'        => ! empty( $post->post_content ) ? $post->post_content : null,
            'author'      => ! empty( $author = get_user_by( 'id', $post->post_author ) ) ? $author->display_name : null,
            'categories'  => array_map( function ( $catId ) {
                $category = get_category( $catId );
                return ! empty( $category->name ) ? htmlspecialchars_decode( $category->name ) : null;
            }, wp_get_post_categories( $post->ID ) ),
            'tags'        => array_map( function ( $term ) {
                return ! empty( $term->name ) ? $term->name : null;
            }, wp_get_post_tags( $post->ID ) ),
            'publishedAt' => ! empty( $post->post_date_gmt ) ? $post->post_date_gmt : null,
        ];
        switch ( $post->post_type ) {
            case self::WP_POST_TYPE_PRODUCT:
                $product                = wc_get_product( $post->ID );
                $document['categories'] = wp_get_post_terms( $post->ID, 'product_cat', [ 'fields' => 'names' ] );
                $document['tags']       = wp_get_post_terms( $post->ID, 'product_tag', [ 'fields' => 'names' ] );
                $document['excerpt']    = $product->get_short_description();
                $document['price']      = (int) $product->get_price();
                if ( $this->wts_settings['woocommerce_products_sku'] ) {
                    $document['sku']        = $product->get_sku();
                }
                $document['attributes'] = [];
                /** @var WC_Product_Attribute $attribute */
                foreach ( $product->get_attributes() as $attributeKey => $attribute ) {
                    if ( ! $attribute->get_visible() ) {
                        continue;
                    }
                    $terms = $attribute->get_terms();
                    if ( ! empty( $terms ) ) {
                        foreach ( $terms as $term ) {
                            $document['attributes'][] = [
                                'attribute' => wc_attribute_label( $attributeKey ),
                                'value'     => $term->name,
                            ];
                        }
                    } else {
                        foreach ( $attribute->get_options() as $option ) {
                            $document['attributes'][] = [
                                'attribute' => wc_attribute_label( $attributeKey ),
                                'value'     => $option,
                            ];
                        }
                    }
                }
                $document['status'] = $product->get_stock_status() === 'instock' ? 1 : 0;
            case self::WP_POST_TYPE_POST:
            case self::WP_POST_TYPE_PAGE:
                $document['image'] = ! empty( $thumbnail = get_the_post_thumbnail_url( $post->ID ) ) ? $thumbnail : null;
                break;
            case self::WP_POST_TYPE_ATTACHMENT:
                $document['type']  = 'media';
                $document['title'] = str_replace( '-', ' ', $document['title'] );
                if ( array_key_exists( $post->post_mime_type, self::MIME_TYPES_IMAGES ) ) {
                    $document['image'] = ! empty( $post->guid ) ? $post->guid : null;
                } elseif (
                    ! empty( $this->wts_settings['media_doc_files'] ) &&
                    array_key_exists( $post->post_mime_type, self::MIME_TYPES_DOCS )
                ) {
                    $document['docFileType'] = self::MIME_TYPES_DOCS[ $post->post_mime_type ];
                    $document['docFileBody'] = @base64_encode( file_get_contents( get_attached_file( $post->ID ) ) );
                }
                break;
            case self::WP_POST_TYPE_FORUM_REPLY:
                $topic = get_post( $post->post_parent );
                if ( empty( $topic ) ) {
                    return null; // should be skipped
                }
                $document['title'] = __( 'In reply to:', 'chilisearch' ) . ' ' . $topic->post_title;
                $document['link']  = get_permalink( $topic->ID ) . "#post-" . $post->ID;
            case self::WP_POST_TYPE_FORUM_FORUM:
            case self::WP_POST_TYPE_FORUM_TOPIC:
                $document['type']    = 'forum';
                $document['excerpt'] = substr( $document['body'], 0, 300 );
                break;
        }
        if (
            ( $post->post_type === self::WP_POST_TYPE_POST && ! empty( $this->wts_settings['posts_approved_comments'] ) ) ||
            ( $post->post_type === self::WP_POST_TYPE_PAGE && ! empty( $this->wts_settings['pages_approved_comments'] ) ) ||
            ( $post->post_type === self::WP_POST_TYPE_ATTACHMENT && ! empty( $this->wts_settings['media_approved_comments'] ) ) ||
            ( $post->post_type === self::WP_POST_TYPE_PRODUCT && ! empty( $this->wts_settings['woocommerce_products_approved_comments'] ) )
        ) {
            $document['comments'] = array_map( function ( $comment ) {
                return (string) $comment->comment_content;
            }, get_comments( [ 'post_id' => $post->ID ] ) );
        }

        return $document;
    }

    protected function get_document_id_from_post( $post ) {
        return sprintf( '%s-%d', $post->post_type, $post->ID );
    }

    public function wp_ajax_admin_ajax_get_posts_count() {
        $post_type_count = [
            self::WP_POST_TYPE_POST       => 0,
            self::WP_POST_TYPE_PAGE       => 0,
            self::WP_POST_TYPE_ATTACHMENT => 0,
            'post_comments'               => 0,
            'page_comments'               => 0,
            'attachment_comments'         => 0,
            'attachment_docs'             => 0,
        ];
        if ( $this->is_bbpress_active() ) {
            $post_type_count += [
                self::WP_POST_TYPE_FORUM_FORUM => 0,
                self::WP_POST_TYPE_FORUM_TOPIC => 0,
                self::WP_POST_TYPE_FORUM_REPLY => 0,
            ];
        }
        if ( $this->is_woocommerce_active() ) {
            $post_type_count += [
                self::WP_POST_TYPE_PRODUCT => 0,
                'product_comments'         => 0,
                'product_outofstock'       => 0,
            ];
        }
        $admin_get_active_posts = $this->admin_get_active_posts( self::WP_POST_TYPES );
        foreach ( $admin_get_active_posts as $post ) {
            if ( $post->post_type === self::WP_POST_TYPE_POST || $post->post_type === self::WP_POST_TYPE_PAGE || $post->post_type === self::WP_POST_TYPE_ATTACHMENT ) {
                $post_type_count[ $post->post_type ] ++;
            }
            if ( $post->post_type === self::WP_POST_TYPE_POST || $post->post_type === self::WP_POST_TYPE_PAGE || $post->post_type === self::WP_POST_TYPE_ATTACHMENT || $post->post_type === self::WP_POST_TYPE_PRODUCT ) {
                $post_type_count[ $post->post_type . '_comments' ] += wp_count_comments( $post->ID )->approved;
            }
            if ( $post->post_type === self::WP_POST_TYPE_ATTACHMENT && array_key_exists( $post->post_mime_type, self::MIME_TYPES_DOCS ) ) {
                $post_type_count['attachment_docs'] ++;
            }
            if ( $post->post_type === self::WP_POST_TYPE_PRODUCT ) {
                $product = wc_get_product( $post->ID );
                if ( $product->get_stock_status() === 'instock' ) {
                    $post_type_count[ self::WP_POST_TYPE_PRODUCT ] ++;
                } elseif ( $product->get_stock_status() === 'outofstock' ) {
                    $post_type_count['product_outofstock'] ++;
                }
            }
        }
        wp_send_json( [ 'status' => true, 'posts_count' => $post_type_count ] );
    }

    public function client_enqueue_scripts() {
        if ( empty( $this->configs['site_api_secret'] ) ) {
            return;
        }
        wp_enqueue_script(
            'chilisearch-settings-js',
            esc_url( self::CHILISEARCH_CDN_BASE_URI . 'js/app.js' ),
            [],
            CHILISEARCH_VERSION,
            true
        );

        $params = json_encode( $this->get_js_init_parameters() );

        wp_add_inline_script( 'chilisearch-settings-js', "ChiliSearch.init($params);" );
    }

    public function get_or_create_search_page() {
        if ( isset( $this->settings['search_page_id'] ) && $this->settings['search_page_id'] > 1 ) {
            $search_page = get_post( $this->settings['search_page_id'] );
            if ( ! empty( $search_page ) && $search_page->post_status === 'publish' ) {
                return get_permalink( $search_page->ID );
            } else {
                $this->get_settings();
                $this->settings['search_page_id'] = - 1;
                $this->set_settings();
            }
        }

        return esc_url( home_url( '/' ) );
    }

    public function i18n() {
        load_plugin_textdomain( 'chilisearch', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
    }

    public function default_search_page() {
        if ( $this->settings['search_page_id'] == - 1 && ! empty( $_GET['chilisearch-query'] ) ) {
            require_once CHILISEARCH_DIR . '/templates/client_default_search_page.php';
            // In our template we add header and footer ourselves,
            // so we need to stop execution here to avoid re-rendering
            // them after our footer.
            die();
        }
    }

    public function admin_chilisearch_options_page() {
        $this->get_configs();
        if ( empty( $this->configs['site_api_secret'] ) || empty( $this->configs['get_started_api_finished'] ) ) {
            return require CHILISEARCH_DIR . '/templates/admin_get_started_register.php';
        }
        $tab = ! empty( $_GET['tab'] ) ? $_GET['tab'] : 'analytics';
        if ( $tab === 'plans' ) {
            return require CHILISEARCH_DIR . '/templates/admin_choose_plan.php';
        }
        if ( empty( $this->configs['get_started_config_finished'] ) && $tab !== 'where-to-search' ) {
            wp_redirect( admin_url( 'admin.php?page=chilisearch&tab=where-to-search&get-started' ) );
        }
        ?>
        <h1><?= __( 'Chili Search', 'chilisearch' ) ?></h1>
        <h2 class="nav-tab-wrapper">
            <a href="<?= esc_url( admin_url( 'admin.php?page=chilisearch&tab=analytics' ) ) ?>" class="nav-tab <?= $tab === 'analytics' ? 'nav-tab-active' : '' ?>"><?= __( 'Analytics', 'chilisearch' ) ?></a>
            <a href="<?= esc_url( admin_url( 'admin.php?page=chilisearch&tab=settings' ) ) ?>" class="nav-tab <?= $tab === 'settings' ? 'nav-tab-active' : '' ?>"><?= __( 'Settings', 'chilisearch' ) ?></a>
            <a href="<?= esc_url( admin_url( 'admin.php?page=chilisearch&tab=where-to-search' ) ) ?>" class="nav-tab <?= $tab === 'where-to-search' ? 'nav-tab-active' : '' ?>"><?= __( 'Where to Search', 'chilisearch' ) ?></a>
            <a href="<?= esc_url( admin_url( 'admin.php?page=chilisearch&tab=demo' ) ) ?>" class="nav-tab <?= $tab === 'demo' ? 'nav-tab-active' : '' ?>"><?= __( 'Demo', 'chilisearch' ) ?></a>
        </h2>
        <?php
        switch ( $tab ) {
            case 'settings':
                return require CHILISEARCH_DIR . '/templates/admin_tab_settings.php';
            case 'where-to-search':
                return require CHILISEARCH_DIR . '/templates/admin_tab_wts.php';
            case 'indexing':
                return require CHILISEARCH_DIR . '/templates/admin_tab_indexing.php';
            case 'demo':
                wp_enqueue_script(
                    'chilisearch-settings-js',
                    esc_url( self::CHILISEARCH_CDN_BASE_URI . 'js/app.js' ),
                    [],
                    CHILISEARCH_VERSION,
                    true
                );
                $params = $this->get_js_init_parameters();
                $params['searchPage'] = admin_url( 'admin.php?page=chilisearch&tab=demo' );
                $params = json_encode( $params );
                wp_add_inline_script( 'chilisearch-settings-js', "ChiliSearch.init($params);" );

                return require CHILISEARCH_DIR . '/templates/admin_tab_demo.php';
            case 'analytics':
                if ( isset( $_POST['gift-code'] ) ) {
                    list( $responseCode, $payload ) = $this->send_request( 'POST', 'website/redeem-gift-code', ['code' => $_POST['gift-code']] );
                    if ( $responseCode === 200 ) { ?>
                        <div class="notice notice-success is-dismissible">
                            <p><?= __( sprintf('Gift code redeemed successfully! %d days added to your premium service.', isset($payload->addedDaysToService) ? $payload->addedDaysToService : 0), 'chilisearch' ); ?></p>
                        </div>
                    <?php } else { ?>
                        <div class="notice notice-error is-dismissible">
                            <p><?= __( 'Could not redeem this gift code!', 'chilisearch' ); ?></p>
                            <p><?= esc_html( isset($payload->message) ? $payload->message : __('No message!', 'chilisearch') ); ?></p>
                        </div>
                    <?php }
                    $this->get_website_info(true);
                }
            default:
                return require CHILISEARCH_DIR . '/templates/admin_tab_analytics.php';
        }
    }

    public function get_current_plan() {
        $siteInfo = $this->get_website_info();
        return isset( $siteInfo['plan'] ) ? esc_html( $siteInfo['plan'] ) : 'basic';
    }

    public function get_website_info($forceFresh = false) {
        if ( empty( $this->configs['site_api_secret'] ) ) {
            return null;
        }
        if ( ! empty( $this->configs['website_info']['last_check'] ) && ! isset( $_GET['fresh'] ) && empty( $forceFresh )) {
            $seconds_ago = microtime( true ) - $this->configs['website_info']['last_check'];
            if ( $seconds_ago < 10 * 60 ) {
                return $this->configs['website_info'];
            }
        }
        list( $getSiteInfoResponseCode, $siteInfo ) = $this->send_request( 'GET', 'website' );
        if ( $getSiteInfoResponseCode === 401 ) {
            unset( $this->configs['site_api_secret'], $this->configs['get_started_config_finished'] );
            $this->set_configs();

            return null;
        }
        if ( $getSiteInfoResponseCode !== 200 ) {
            return null;
        }
        if ( ! empty( $siteInfo->apiKey ) && $siteInfo->apiKey !== $this->configs['site_api_key'] ) {
            $this->configs['site_api_key'] = $siteInfo->apiKey;
        }
        $this->configs['website_info']               = (array) $siteInfo;
        $this->configs['website_info']['last_check'] = microtime( true );
        $this->set_configs();

        return $this->configs['website_info'];
    }

    /**
     * @param int $postId
     * @param WP_Post $post
     * @param bool $update
     *
     * @return void|bool
     */
    public function admin_save_post_hook( $postId, $post, $update ) {
        if ( empty( $this->configs['site_api_secret'] ) ) {
            return true;
        }
        $active_post_types = $this->get_active_post_types();
        if ( ! in_array( $post->post_type, $active_post_types, true ) ) {
            return true;
        }
        try {
            if ( $post->post_status === 'publish' ) {
                $document = $this->transform_post_to_document( $post );
                if ( empty( $document ) ) {
                    return true;
                }
                list( $putDocumentResponseCode, $putDocumentResponseBody ) = $this->send_request(
                    'PUT',
                    'documents',
                    $document
                );
                if ( $putDocumentResponseCode >= 200 && $putDocumentResponseCode <= 299 ) {
                    return true;
                }
            } else {
                $this->send_request( 'DELETE', 'documents/' . $this->get_document_id_from_post( $post ) );
            }
        } catch ( Exception $exception ) {
        }

        return true;
    }

    protected function get_js_init_parameters() {
        $params = [
            'apiKey'     => $this->configs['site_api_key'],
            'searchPage' => $this->get_or_create_search_page(),
            'configs'    => [
                'extraInputSelector' => $this->settings['auto_search_detection'] ? $this->settings['search_input_selector'] : '',
                'searchPageSize'     => $this->settings['search_page_size'],
                'saytPageSize'       => $this->settings['sayt_page_size'],
                'wordType'           => $this->settings['search_word_type'],
                'currency'           => '',
                'sortBy'             => $this->get_current_plan() === 'premium' ? self::SORT_BYS[ $this->settings['sort_by'] ] : self::SORT_BYS[ self::SORT_BY_RELEVANCY ],
                'displayInResult'    => [
                    'thumbnail'    => (bool) $this->settings['display_result_image'],
                    'productPrice' => $this->get_current_plan() === 'premium' && $this->settings['display_result_product_price'],
                    'except'       => (bool) $this->settings['display_result_excerpt'],
                    'categories'   => (bool) $this->settings['display_result_categories'],
                    'tags'         => (bool) $this->settings['display_result_tags'],
                ],
                'weight'             => [
                    'title'      => $this->settings['weight_title'],
                    'excerpt'    => $this->settings['weight_excerpt'],
                    'body'       => $this->settings['weight_body'],
                    'tags'       => $this->settings['weight_tags'],
                    'categories' => $this->settings['weight_categories'],
                ],
                'filters'            => [],
                'isRTL'              => (bool) is_rtl(),
                'removeBrand'        => $this->get_current_plan() === 'premium' && ! $this->settings['display_chilisearch_brand'],
            ],
            'phraseBook' => [
                'powered-by'                 => __( 'powered by', 'chilisearch' ),
                'search-powered-by'          => __( 'search powered by', 'chilisearch' ),
                'no-result-message'          => __( 'Couldn\'t find anything related …', 'chilisearch' ),
                'error-message'              => __( 'Oops!<small>Sorry, there\'s some thing wrong. Please try again.</small>', 'chilisearch' ),
                'input-placeholder'          => __( 'Search …', 'chilisearch' ),
                'sayt-init-message'          => __( 'Search …', 'chilisearch' ),
                'form-submit-value'          => __( 'Search', 'chilisearch' ),
                'search-result-result-count' => __( 'About {totalCount} results ({timeTook} seconds)', 'chilisearch' ),
                'prev'                       => __( 'Prev', 'chilisearch' ),
                'next'                       => __( 'Next', 'chilisearch' ),
                'category'                   => __( 'category', 'chilisearch' ),
                'price'                      => __( 'price', 'chilisearch' ),
                'search-between'             => __( 'search-between', 'chilisearch' ),
                'to'                         => __( 'to', 'chilisearch' ),
                'all'                        => __( 'all', 'chilisearch' ),
                'published'                  => __( 'published', 'chilisearch' ),
            ],
        ];
        if ($this->is_woocommerce_active()) {
            $params['configs']['currency'] = html_entity_decode(get_woocommerce_currency_symbol());
        }
        if ( $this->settings['filter_type'] ) {
            $active_post_types = [];
            if ( ! empty( $this->wts_settings['posts'] ) ) {
                $active_post_types['post'] = __( 'Posts', 'chilisearch' );
            }
            if ( ! empty( $this->wts_settings['pages'] ) ) {
                $active_post_types['page'] = __( 'Pages', 'chilisearch' );
            }
            if ( ! empty( $this->wts_settings['media'] ) ) {
                $active_post_types['media'] = __( 'Media', 'chilisearch' );
            }
            if ( ! empty( $this->wts_settings['woocommerce_products'] ) ) {
                $active_post_types['product'] = __( 'Products', 'chilisearch' );
            }
            if ( ! empty( $this->wts_settings['bbpress_forum'] ) ) {
                $active_post_types['forum'] = __( 'Forums', 'chilisearch' );
            }
            if ( count( $active_post_types ) > 1 ) {
                $params['configs']['filters']['type'] = $active_post_types;
            }
        }
        if ( $this->settings['filter_category'] ) {
            $params['configs']['filters']['categories'] = array_map( function ( $category ) {
                return htmlspecialchars_decode( $category->name );
            }, get_categories( [
                'taxonomy' => 'category',
                'orderby'  => 'count',
                'order'    => 'DESC'
            ] ) );
            if ( $this->is_woocommerce_active() ) {
                $params['configs']['filters']['categories'] = array_merge(
                    array_map( function ( $category ) {
                        return htmlspecialchars_decode( $category->name );
                    }, get_categories( [
                        'taxonomy' => 'product_cat',
                        'orderby'  => 'count',
                        'order'    => 'DESC'
                    ] ) ),
                    $params['configs']['filters']['categories']
                );
            }
        }
        if ( $this->settings['filter_price'] && $this->is_woocommerce_active()) {
            $params['configs']['filters']['price'] = @$this->get_filtered_price();
        }
        if ( $this->settings['filter_publishedat']) {
            $active_post_types = $this->get_active_post_types();
            $min_post = new WP_Query( [
                'post_type'      => $active_post_types,
                'post_status'    => 'inherit,publish',
                'posts_per_page' => 1,
                'orderby'        => 'post_date',
                'order'          => 'ASC',
            ] );
            if (!empty($min_post->post->post_date)) {
                $params['configs']['filters']['publishedat']['from'] = date('Y-m-d', strtotime($min_post->post->post_date));
            }
            $max_post = new WP_Query( [
                'post_type'      => $active_post_types,
                'post_status'    => 'inherit,publish',
                'posts_per_page' => 1,
                'orderby'        => 'post_date',
                'order'          => 'DESC',
            ] );
            if (!empty($max_post->post->post_date)) {
                $params['configs']['filters']['publishedat']['to'] = date('Y-m-d', strtotime($max_post->post->post_date));
            }
        }
        return $params;
    }

    protected function get_filtered_price() {
        global $wpdb;

        $args =  WC_Query::get_main_query();

        $tax_query  = isset( $args->tax_query->queries ) ? $args->tax_query->queries : array();
        $meta_query = isset( $args->query_vars['meta_query'] ) ? $args->query_vars['meta_query'] : array();

        foreach ( $meta_query + $tax_query as $key => $query ) {
            if ( ! empty( $query['price_filter'] ) || ! empty( $query['rating_filter'] ) ) {
                unset( $meta_query[ $key ] );
            }
        }

        $meta_query = new \WP_Meta_Query( $meta_query );
        $tax_query  = new \WP_Tax_Query( $tax_query );

        $meta_query_sql = $meta_query->get_sql( 'post', $wpdb->posts, 'ID' );
        $tax_query_sql  = $tax_query->get_sql( $wpdb->posts, 'ID' );

        $sql = "SELECT min( FLOOR( price_meta.meta_value ) ) as min_price, max( CEILING( price_meta.meta_value ) ) as max_price FROM {$wpdb->posts} ";
        $sql .= " LEFT JOIN {$wpdb->postmeta} as price_meta ON {$wpdb->posts}.ID = price_meta.post_id " . $tax_query_sql['join'] . $meta_query_sql['join'];
        $sql .= " 	WHERE {$wpdb->posts}.post_type IN ('product')
			AND {$wpdb->posts}.post_status = 'publish'
			AND price_meta.meta_key IN ('_price')
			AND price_meta.meta_value > '' ";
        $sql .= $tax_query_sql['where'] . $meta_query_sql['where'];

        $prices = $wpdb->get_row( $sql );

        return [
            'min' => floor( $prices->min_price ),
            'max' => ceil( $prices->max_price )
        ];
    }
}

ChiliSearch::getInstance();
