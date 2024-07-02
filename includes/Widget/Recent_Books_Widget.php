<?php

namespace Books\Plugin\Widget;

use WP_Query;
use WP_Widget;

class Recent_Books_Widget extends WP_Widget {
    function __construct() {

        parent::__construct(
            'recent_books_widget',
            __('Recent Books Widget', 'books-plugin'),
            array('description' => __('Displays recent books', 'books-plugin'),)
        );

        add_action('widgets_init',[ $this, 'register_recent_books_widget']);
    }

    public function register_recent_books_widget() {
        register_widget( 'Books\Plugin\Widget\Recent_Books_Widget' );
    }

    public function widget( $args, $instance ) {
        echo $args['before_widget'];
        if ( ! empty( $instance['title'] ) ) {
            echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
        }

        $number = !empty($instance['number']) ? $instance['number'] : 5;

        $recent_posts = new WP_Query(array(
            'posts_per_page' => $number,
            'post_status'    => 'publish',
            'post_type'      => 'book',
        ));

        if ( $recent_posts->have_posts() ) {
            echo '<ul>';
            while ( $recent_posts->have_posts() ) {
                $recent_posts->the_post();
                echo '<li><a href="' . get_permalink() . '">' . get_the_title() . '</a></li>';
            }
            echo '</ul>';
            wp_reset_postdata();
        } else {
            echo '<p>' . __( 'No books found.', 'textdomain' ) . '</p>';
        }

        echo $args['after_widget'];
    }

    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : __('Recent Books', 'books-plugin');
        $number = !empty($instance['number']) ? $instance['number'] : 5;
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php _e('Title:', 'books-plugin'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('number')); ?>"><?php _e('Number of posts to show:', 'books-plugin'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('number')); ?>" name="<?php echo esc_attr($this->get_field_name('number')); ?>" type="number" value="<?php echo esc_attr($number); ?>">
        </p>
        <?php
    }

    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        $instance['number'] = (!empty($new_instance['number'])) ? intval($new_instance['number']) : 5;
        return $instance;
    }

}