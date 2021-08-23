<?php

namespace ChiliSearch;
/**
 * Chili Search Widget.
 *
 * @package ChiliSearch\Widgets
 * @since 2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class Widget_Search extends \WP_Widget {

    public function __construct() {
        $widget_ops = array(
            'classname'                   => 'widget_chili_search',
            'description'                 => __( 'Chili Search Widget', 'chilisearch' ),
            'customize_selective_refresh' => true,
        );
        parent::__construct( 'chilisearch_form', __( 'Chili Search', 'chilisearch' ), $widget_ops );
    }

    public function widget( $args, $instance ) {
        $chilisearch = \ChiliSearch::getInstance();

        $title                          = ! empty( $instance['title'] ) ? $instance['title'] : '';
        $font                           = ! empty( $instance['font'] ) ? $instance['font'] : '';
        $search_input_placeholder       = ! empty( $instance['search_input_placeholder'] ) ? $instance['search_input_placeholder'] : esc_attr_x( 'Search …', 'placeholder' );
        $sayt_result_number             = ! empty( $instance['sayt_result_number'] ) ? $instance['sayt_result_number'] : 5;
        $submit_button_text             = ! empty( $instance['submit_button_text'] ) ? $instance['submit_button_text'] : __( 'Search', 'chilisearch' );
        $submit_button_background_color = ! empty( $instance['submit_button_background_color'] ) ? $instance['submit_button_background_color'] : '#d35050';
        $submit_button_color            = ! empty( $instance['submit_button_color'] ) ? $instance['submit_button_color'] : '#ffffff';
        $display_submit_button          = ! isset( $instance['display_submit_button'] ) || $instance['display_submit_button'];
        $display_thumbnail              = ! isset( $instance['display_thumbnail'] ) || $instance['display_thumbnail'];
        $display_excerpt                = ! isset( $instance['display_excerpt'] ) || $instance['display_excerpt'];
        $display_categories             = ! isset( $instance['display_categories'] ) || $instance['display_categories'];
        $display_tags                   = ! isset( $instance['display_tags'] ) || $instance['display_tags'];
        $voice_search_enabled           = ! isset( $instance['voice_search_enabled'] ) || $instance['voice_search_enabled'];

        $title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

        echo $args['before_widget'];
        if ( $title ) {
            echo $args['before_title'] . $title . $args['after_title'];
        }
        ?>
        <form action="<?= $chilisearch->get_or_create_search_page() ?>" method="GET" role="search" class="cs-search-form <?= is_rtl() ? 'cs-search-form--rtl' : '' ?>" style="<?= $font ? "font-family:{$font};" : '' ?>">
            <input type="search" placeholder="<?= $search_input_placeholder ?>" name="cs[query]" autocomplete="off" data-result-count="<?= $sayt_result_number ?>" <?= $display_thumbnail ? '' : 'data-no-thumbnail="1"' ?> <?= $display_excerpt ? '' : 'data-no-excerpt="1"' ?> <?= $display_categories ? '' : 'data-no-categories="1"' ?> <?= $display_tags ? '' : 'data-no-tags="1"' ?> <?= $voice_search_enabled ? '' : 'data-no-voice-search="1"' ?>>
            <input class="cs-search-form__submit-button" type="submit" value="<?= $submit_button_text ?>" style="<?= $display_submit_button ? '' : 'display:none;' ?>background:<?= $submit_button_background_color ?>;color:<?= $submit_button_color ?>">
        </form>
        <?php
        echo $args['after_widget'];
    }

    public function form( $instance ) {
        $instance = wp_parse_args(
            (array) $instance,
            [
                'title'                          => '',
                'font'                           => '',
                'search_input_placeholder'       => esc_attr_x( 'Search …', 'placeholder' ),
                'sayt_result_number'             => 5,
                'submit_button_text'             => __( 'Search', 'chilisearch' ),
                'submit_button_background_color' => '#d35050',
                'submit_button_color'            => '#ffffff',
                'display_submit_button'          => true,
                'display_thumbnail'              => true,
                'display_excerpt'                => true,
                'display_categories'             => true,
                'display_tags'                   => true,
                'voice_search_enabled'           => true,
            ]
        );
        ?>
        <p><?= sprintf( __( 'Update search setting in %sChili Search Plugin%s', 'chilisearch' ), '<a href="' . esc_url( admin_url( 'admin.php?page=chilisearch&tab=settings' ) ) . '" target="_blank">', '</a>' ) ?></p>

        <h3><?= __( 'Search Form', 'chilisearch' ) ?>:</h3>
        <p>
            <label for="<?= $this->get_field_id( 'title' ); ?>"><?= __( 'Title:', 'chilisearch' ); ?></label>
            <input class="widefat" id="<?= $this->get_field_id( 'title' ); ?>"
                   name="<?= $this->get_field_name( 'title' ); ?>" type="text"
                   value="<?= esc_attr( $instance['title'] ); ?>"/>
        </p>
        <p>
            <label for="<?= $this->get_field_id( 'font' ); ?>"><?= __( 'Font family:', 'chilisearch' ); ?></label>
            <input class="widefat" id="<?= $this->get_field_id( 'font' ); ?>"
                   name="<?= $this->get_field_name( 'font' ); ?>" type="text"
                   value="<?= esc_attr( $instance['font'] ); ?>"/>
        </p>
        <p>
            <label for="<?= $this->get_field_id( 'search_input_placeholder' ); ?>"><?= __( 'Search input placeholder', 'chilisearch' ); ?></label>
            <input class="widefat" id="<?= $this->get_field_id( 'search_input_placeholder' ); ?>"
                   name="<?= $this->get_field_name( 'search_input_placeholder' ); ?>" type="text"
                   value="<?= esc_attr( $instance['search_input_placeholder'] ); ?>"/>
        </p>
        <p>
            <label for="<?= $this->get_field_id( 'sayt_result_number' ); ?>"><?= __( 'Results number', 'chilisearch' ); ?></label>
            <input class="widefat" id="<?= $this->get_field_id( 'sayt_result_number' ); ?>"
                   name="<?= $this->get_field_name( 'sayt_result_number' ); ?>" type="number"
                   value="<?= esc_attr( $instance['sayt_result_number'] ); ?>"/>
        </p>
        <p>
            <input class="widefat" id="<?= $this->get_field_id( 'voice_search_enabled' ); ?>"
                   name="<?= $this->get_field_name( 'voice_search_enabled' ); ?>" type="checkbox"
                   value="true" <?= $instance['voice_search_enabled'] ? 'checked' : '' ?>/>
            <label for="<?= $this->get_field_id( 'voice_search_enabled' ); ?>"><?= __( 'Voice Search', 'chilisearch' ) ?></label>
        </p>
        <p>
            <input class="widefat" id="<?= $this->get_field_id( 'display_thumbnail' ); ?>"
                   name="<?= $this->get_field_name( 'display_thumbnail' ); ?>" type="checkbox"
                   value="true" <?= $instance['display_thumbnail'] ? 'checked' : '' ?>/>
            <label for="<?= $this->get_field_id( 'display_thumbnail' ); ?>"><?= __( 'Display thumbnail', 'chilisearch' ) ?></label>
        </p>
        <p>
            <input class="widefat" id="<?= $this->get_field_id( 'display_excerpt' ); ?>"
                   name="<?= $this->get_field_name( 'display_excerpt' ); ?>" type="checkbox"
                   value="true" <?= $instance['display_excerpt'] ? 'checked' : '' ?>/>
            <label for="<?= $this->get_field_id( 'display_excerpt' ); ?>"><?= __( 'Display excerpt', 'chilisearch' ) ?></label>
        </p>
        <p>
            <input class="widefat" id="<?= $this->get_field_id( 'display_categories' ); ?>"
                   name="<?= $this->get_field_name( 'display_categories' ); ?>" type="checkbox"
                   value="true" <?= $instance['display_categories'] ? 'checked' : '' ?>/>
            <label for="<?= $this->get_field_id( 'display_categories' ); ?>"><?= __( 'Display categories', 'chilisearch' ) ?></label>
        </p>
        <p>
            <input class="widefat" id="<?= $this->get_field_id( 'display_tags' ); ?>"
                   name="<?= $this->get_field_name( 'display_tags' ); ?>" type="checkbox"
                   value="true" <?= $instance['display_tags'] ? 'checked' : '' ?>/>
            <label for="<?= $this->get_field_id( 'display_tags' ); ?>"><?= __( 'Display tags', 'chilisearch' ) ?></label>
        </p>

        <h3><?= __( 'Submit Button', 'chilisearch' ) ?>:</h3>
        <p>
            <input class="widefat" id="<?= $this->get_field_id( 'display_submit_button' ); ?>"
                   name="<?= $this->get_field_name( 'display_submit_button' ); ?>" type="checkbox"
                   value="true" <?= $instance['display_submit_button'] ? 'checked' : '' ?>/>
            <label for="<?= $this->get_field_id( 'display_submit_button' ); ?>"><?= __( 'Display submit button', 'chilisearch' ) ?></label>
        </p>
        <p>
            <label for="<?= $this->get_field_id( 'submit_button_text' ); ?>"><?= __( 'Submit button text', 'chilisearch' ); ?></label>
            <input class="widefat" id="<?= $this->get_field_id( 'submit_button_text' ); ?>"
                   name="<?= $this->get_field_name( 'submit_button_text' ); ?>" type="text"
                   value="<?= esc_attr( $instance['submit_button_text'] ); ?>"/>
        </p>
        <p>
            <label for="<?= $this->get_field_id( 'submit_button_background_color' ); ?>"><?= __( 'Submit button background color', 'chilisearch' ); ?></label>
            <input class="widefat" id="<?= $this->get_field_id( 'submit_button_background_color' ); ?>"
                   name="<?= $this->get_field_name( 'submit_button_background_color' ); ?>" type="color"
                   value="<?= esc_attr( $instance['submit_button_background_color'] ); ?>"/>
        </p>
        <p>
            <label for="<?= $this->get_field_id( 'submit_button_color' ); ?>"><?= __( 'Submit button color', 'chilisearch' ); ?></label>
            <input class="widefat" id="<?= $this->get_field_id( 'submit_button_color' ); ?>"
                   name="<?= $this->get_field_name( 'submit_button_color' ); ?>" type="color"
                   value="<?= esc_attr( $instance['submit_button_color'] ); ?>"/>
        </p>
        <?php
    }

    public function update( $new_instance, $old_instance ) {
        $instance                                   = array();
        $instance['title']                          = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';
        $instance['font']                           = ( ! empty( $new_instance['font'] ) ) ? sanitize_text_field( $new_instance['font'] ) : '';
        $instance['search_input_placeholder']       = ( ! empty( $new_instance['search_input_placeholder'] ) ) ? sanitize_text_field( $new_instance['search_input_placeholder'] ) : '';
        $instance['sayt_result_number']             = ( ! empty( $new_instance['sayt_result_number'] ) ) ? sanitize_text_field( $new_instance['sayt_result_number'] ) : '';
        $instance['submit_button_text']             = ( ! empty( $new_instance['submit_button_text'] ) ) ? sanitize_text_field( $new_instance['submit_button_text'] ) : '';
        $instance['submit_button_background_color'] = ( ! empty( $new_instance['submit_button_background_color'] ) ) ? sanitize_text_field( $new_instance['submit_button_background_color'] ) : '';
        $instance['submit_button_color']            = ( ! empty( $new_instance['submit_button_color'] ) ) ? sanitize_text_field( $new_instance['submit_button_color'] ) : '';
        $instance['display_submit_button']          = ( ! empty( $new_instance['display_submit_button'] ) && $new_instance['display_submit_button'] === 'true' );
        $instance['voice_search_enabled']           = ( ! empty( $new_instance['voice_search_enabled'] ) && $new_instance['voice_search_enabled'] === 'true' );
        $instance['display_thumbnail']              = ( ! empty( $new_instance['display_thumbnail'] ) && $new_instance['display_thumbnail'] === 'true' );
        $instance['display_excerpt']                = ( ! empty( $new_instance['display_excerpt'] ) && $new_instance['display_excerpt'] === 'true' );
        $instance['display_categories']             = ( ! empty( $new_instance['display_categories'] ) && $new_instance['display_categories'] === 'true' );
        $instance['display_tags']                   = ( ! empty( $new_instance['display_tags'] ) && $new_instance['display_tags'] === 'true' );

        return $instance;
    }
}
