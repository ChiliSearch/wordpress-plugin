<?php
namespace ChiliSearch;
use Elementor\Controls_Manager;

/**
 * Elementor Chili Search Widget.
 *
 * @package ChiliSearch\ElementorSearch
 * @since 2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

/**
 * Elementor Chili Search widget.
 *
 * Elementor widget that shows Chili Search form in the page.
 *
 * @since 2.0.4
 */
class Widget_ElementorSearch extends \Elementor\Widget_Base {

	public function get_name() {
		return 'chilisearch';
	}

	public function get_title() {
		return __( 'Chili Search', 'chilisearch' );
	}

	public function get_icon() {
		return 'eicon-site-search';
	}

	public function get_keywords() {
		return [ 'search', 'chili', 'chilisearch', 'chili search' , 'ajax' , 'jet' ];
	}

	public function is_reload_preview_required() {
		return true;
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_search_form',
			[
				'label' => __( 'Search Form', 'chilisearch' ),
			]
		);

        $this->add_control(
            'chili_search_setting_page',
            [
                'type' => Controls_Manager::RAW_HTML,
                'content_classes' => 'elementor-control-field-description',
                'raw' => '<p>' . sprintf(__( 'Update search setting in %sChili Search Plugin%s', 'chilisearch' ), '<a href="' . esc_url( admin_url( 'admin.php?page=chilisearch&tab=settings' ) ) . '" target="_blank">', '</a>') . '</p>',
            ]
        );

        $this->add_control(
            'font',
            [
                'label' => __( 'Font', 'chilisearch' ),
                'type' => Controls_Manager::FONT,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'search_input_placeholder',
            [
                'label' => __( 'Search input placeholder', 'chilisearch' ),
                'type' => Controls_Manager::TEXT,
                'separator' => 'before',
                'default' => esc_attr_x( 'Search …', 'placeholder' ),
            ]
        );

        $this->add_control(
            'sayt_result_number',
            [
                'label' => __( 'Results number', 'chilisearch' ),
                'type' => Controls_Manager::NUMBER,
                'separator' => 'before',
                'default' => 5,
            ]
        );

		$this->end_controls_section();

		$this->start_controls_section(
			'section_submit_button',
			[
				'label' => __( 'Submit Button', 'chilisearch' ),
			]
		);

        $this->add_control(
            'display_submit_button',
            [
                'label' => __( 'Display submit button', 'chilisearch' ),
                'type' => Controls_Manager::SWITCHER,
                'separator' => 'before',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'submit_button_color',
            [
                'label' => __( 'Submit button color', 'chilisearch' ),
                'type' => Controls_Manager::COLOR,
                'separator' => 'before',
                'default' => '#ffffff',
            ]
        );

        $this->add_control(
            'submit_button_background_color',
            [
                'label' => __( 'Submit button background color', 'chilisearch' ),
                'type' => Controls_Manager::COLOR,
                'separator' => 'before',
                'default' => '#d35050',
            ]
        );

        $this->add_control(
            'submit_button_text',
            [
                'label' => __( 'Submit button text', 'chilisearch' ),
                'type' => Controls_Manager::TEXT,
                'separator' => 'before',
                'default' => __( 'Search', 'chilisearch' ),
            ]
        );

		$this->end_controls_section();
	}

	protected function render() {
        $chilisearch = \ChiliSearch::getInstance();
        $settings = $this->get_settings_for_display();
		?>
        <form action="<?= $chilisearch->get_or_create_search_page() ?>" method="GET" role="search" class="chilisearch-search_form" style="<?= $settings['font'] ? "font-family:{$settings['font']};" : '' ?>">
        <div class="chlisrch-f-sb">
                <label class="chilisearch-search_form_label">
                    <input type="search" placeholder="<?= $settings['search_input_placeholder'] ?>" name="chilisearch-query" autocomplete="off" data-result-count="<?= $settings['sayt_result_number'] ?>">
                </label>
                <input class="chilisearch-search_form_submit" type="submit" value="<?=$settings['submit_button_text']?>" style="<?= $settings['display_submit_button'] === 'yes'?'':'display:none;' ?>background:<?= $settings['submit_button_background_color'] ?>;color:<?= $settings['submit_button_color'] ?>">
            </div>
        </form>
        <script>try{ChiliSearch.processSearchInputs();}catch(e){}</script>
        <?php
	}
}
