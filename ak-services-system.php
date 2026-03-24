<?php
/**
 * Plugin Name: AK Services System (CPT + Elementor Widget)
 * Description: Full Services system with CPT + Elementor widget + GSAP animation
 * Version: 3.0.0
 */

if (!defined('ABSPATH')) exit;

final class AK_Services_System {

    const VERSION = '3.0.0';

    public function __construct() {
        add_action('init', [$this, 'register_cpt']);
        add_action('init', [$this, 'register_taxonomy']);
        add_action('wp_enqueue_scripts', [$this, 'register_assets']);
        add_action('elementor/widgets/register', [$this, 'register_widget']);
    }

    /* ---------------- CPT ---------------- */

    public function register_cpt() {

        $labels = [
            'name' => 'Services',
            'singular_name' => 'Service',
            'menu_name' => 'Services',
            'add_new_item' => 'Add New Service',
            'edit_item' => 'Edit Service',
            'all_items' => 'All Services',
        ];

        register_post_type('services', [
            'labels' => $labels,
            'public' => true,
            'menu_icon' => 'dashicons-screenoptions',
            'supports' => [
                'title',
                'excerpt',
                'thumbnail',
                'page-attributes' // enables menu_order
            ],
            'has_archive' => true,
            'rewrite' => ['slug' => 'services'],
            'show_in_rest' => true,
        ]);
    }

    /* ---------------- TAXONOMY ---------------- */

    public function register_taxonomy() {

        register_taxonomy('service_category', 'services', [
            'label' => 'Service Categories',
            'hierarchical' => true,
            'rewrite' => ['slug' => 'service-category'],
            'show_in_rest' => true,
        ]);
    }

    /* ---------------- ASSETS ---------------- */

    public function register_assets() {

        wp_register_script(
            'gsap',
            'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js',
            [],
            self::VERSION,
            true
        );

        wp_register_script(
            'gsap-scrolltrigger',
            'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js',
            ['gsap'],
            self::VERSION,
            true
        );

        wp_register_style(
            'ak-services-style',
            plugins_url('assets/style.css', __FILE__),
            [],
            self::VERSION
        );

        wp_register_script(
            'ak-services-script',
            plugins_url('assets/script.js', __FILE__),
            ['gsap', 'gsap-scrolltrigger'],
            self::VERSION,
            true
        );
    }

    /* ---------------- ELEMENTOR ---------------- */

    public function register_widget($widgets_manager) {

        if (!did_action('elementor/loaded')) return;

        require_once(__DIR__ . '/includes/class-widget.php');
        $widgets_manager->register(new \AK_Services_Widget());
    }
}

new AK_Services_System();