<?php
/**
 * Search Widget.
 *
 * @package ChiliSearch\Widgets
 * @since 2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class Widget_Search extends WP_Widget {

    public function __construct() {
        $widget_ops = array(
            'classname'                   => 'widget_chilisearch_search',
            'description'                 => __( 'ChiliSearch Search Form Widget', 'chilisearch' ),
            'customize_selective_refresh' => true,
        );
        parent::__construct( 'chilisearch_form', __( 'ChiliSearch Form', 'chilisearch' ), $widget_ops );
    }

    public function widget( $args, $instance ) {
        $title                 = ! empty( $instance['title'] ) ? $instance['title'] : '';
        $display_submit_button = isset( $instance['display_submit_button'] ) ? (bool) $instance['display_submit_button'] : true;

        $title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

        echo $args['before_widget'];
        if ( $title ) {
            echo $args['before_title'] . $title . $args['after_title'];
        }

        $chilisearch = ChiliSearch::getInstance();

        echo '<form action="' . $chilisearch->get_or_create_search_page() . '" method="GET" role="search" class="chilisearch-search_form">
                <div class="chlisrch-f-sb">
                    <label class="chilisearch-search_form_label">
                        <input type="search" placeholder="' . esc_attr_x( 'Search &hellip;', 'placeholder' ) . '" name="chilisearch-query" autocomplete="off">
                    </label>
                    ' . ( $display_submit_button ? '<input class="chilisearch-search_form_submit" type="submit" value="' . esc_attr_x( 'Search', 'submit button' ) . '">' : '' ) . '
                </div>
            </form>';

        echo $args['after_widget'];
    }

    public function form( $instance ) {
        $instance              = wp_parse_args( (array) $instance, array( 'title' => '', 'display_submit_button' => true ) );
        $title                 = $instance['title'];
        $display_submit_button = $instance['display_submit_button'];
        ?>
        <p>Update search setting in <a href="<?= esc_url( admin_url( 'admin.php?page=chilisearch&tab=settings' ) ) ?>" target="_blank">Chili Search Plugin</a></p>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?= __( 'Title:', 'chilisearch' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>"
                   name="<?php echo $this->get_field_name( 'title' ); ?>" type="text"
                   value="<?php echo esc_attr( $title ); ?>"/>
        </p>
        <p>
            <input class="widefat" id="<?php echo $this->get_field_id( 'display_submit_button' ); ?>"
                   name="<?php echo $this->get_field_name( 'display_submit_button' ); ?>" type="checkbox"
                   value="true" <?= $display_submit_button ? 'checked' : '' ?>/>
            <label for="<?php echo $this->get_field_id( 'display_submit_button' ); ?>"><?= __( 'Display submit button', 'chilisearch' ) ?></label>
        </p>
        <?php
    }

    public function update( $new_instance, $old_instance ) {
        $instance                          = array();
        $instance['title']                 = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';
        $instance['display_submit_button'] = ( ! empty( $new_instance['display_submit_button'] ) && $new_instance['display_submit_button'] == 'true' );

        return $instance;
    }
}
