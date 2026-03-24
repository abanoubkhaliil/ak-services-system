<?php

if (!defined('ABSPATH')) exit;

class AK_Services_Widget extends \Elementor\Widget_Base {

    public function get_name() { return 'ak_services'; }

    public function get_title() { return 'AK Services'; }

    public function get_icon() { return 'eicon-post-list'; }

    public function get_categories() { return ['general']; }

    public function get_style_depends() { return ['ak-services-style']; }

    public function get_script_depends() { return ['ak-services-script']; }

    protected function register_controls() {

        $this->start_controls_section('settings', [
            'label' => 'Settings',
        ]);

        $this->add_control('posts_per_page', [
            'label' => 'Number of Services',
            'type' => \Elementor\Controls_Manager::NUMBER,
            'default' => -1,
        ]);

        $this->add_control('order', [
            'label' => 'Order',
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'ASC',
            'options' => [
                'ASC' => 'ASC',
                'DESC' => 'DESC',
            ],
        ]);

        $this->end_controls_section();
    }

    protected function render() {

        $settings = $this->get_settings_for_display();

        $query = new WP_Query([
            'post_type' => 'services',
            'posts_per_page' => $settings['posts_per_page'],
            'orderby' => 'menu_order',
            'order' => $settings['order'],
            'no_found_rows' => true,
        ]);

        if (!$query->have_posts()) {
            echo '<p>No services found.</p>';
            return;
        }

        $uid = 'ak-services-' . $this->get_id();

        echo '<div id="' . esc_attr($uid) . '" class="ak-services-wrapper">';
        echo '<ul class="services">';

        while ($query->have_posts()) {
            $query->the_post();

            $title = get_the_title();
            $desc  = get_the_excerpt();
            $img   = get_the_post_thumbnail_url(get_the_ID(), 'medium');

            echo '<li class="service-item">';

            if ($img) {
                echo '<img src="' . esc_url($img) . '" class="service-icon" />';
            }

            echo '<h3>' . esc_html($title) . '</h3>';
            echo '<p>' . esc_html($desc) . '</p>';
            echo '</li>';
        }

        echo '</ul></div>';

        wp_reset_postdata();
    }
}