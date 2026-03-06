<?php
/**
 * Vadim Business Theme Functions
 * Version: 2.0.0
 */

// === INCLUDES ===
require_once get_template_directory() . '/inc/meta-boxes.php';
require_once get_template_directory() . '/inc/ajax-handlers.php';
require_once get_template_directory() . '/inc/taxonomies.php';

// === THEME SETUP ===
function vadim_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo', [
        'height' => 60,
        'width'  => 200,
        'flex-height' => true,
        'flex-width'  => true,
    ]);
    add_theme_support('html5', ['search-form', 'comment-form', 'gallery', 'caption']);
    add_theme_support('editor-styles');
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');

    register_nav_menus([
        'primary' => __('Primary Menu', 'vadim-business'),
        'footer'  => __('Footer Menu', 'vadim-business'),
    ]);

    set_post_thumbnail_size(1200, 630, true);
    add_image_size('portfolio-thumb', 600, 400, true);
    add_image_size('team-avatar', 300, 300, true);
}
add_action('after_setup_theme', 'vadim_setup');

// === ENQUEUE STYLES & SCRIPTS ===
function vadim_scripts() {
    wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap', [], null);
    wp_enqueue_style('vadim-style', get_stylesheet_uri(), ['google-fonts'], wp_get_theme()->get('Version'));
    wp_enqueue_script('vadim-script', get_template_directory_uri() . '/js/main.js', [], wp_get_theme()->get('Version'), true);

    wp_localize_script('vadim-script', 'vadimAjax', [
        'url'   => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('vadim_ajax_nonce'),
        'rest'  => esc_url_raw(rest_url('vadim/v1/')),
    ]);
}
add_action('wp_enqueue_scripts', 'vadim_scripts');

// === CUSTOMIZER ===
function vadim_customizer($wp_customize) {
    // Hero Section
    $wp_customize->add_section('vadim_hero', [
        'title'    => __('Hero Section', 'vadim-business'),
        'priority' => 30,
    ]);

    $hero_fields = [
        'hero_badge'    => ['label' => 'Hero Badge Text', 'default' => 'Accepting new projects'],
        'hero_title'    => ['label' => 'Hero Title', 'default' => 'We build websites that bring real clients'],
        'hero_accent'   => ['label' => 'Accent Word (underlined)', 'default' => 'real clients'],
        'hero_text'     => ['label' => 'Hero Description', 'default' => 'Full-cycle development: from idea to working product. Websites, Telegram bots, business automation.'],
        'hero_btn_text' => ['label' => 'Button Text', 'default' => 'Start a Project'],
        'hero_btn_url'  => ['label' => 'Button URL', 'default' => '#contact'],
    ];

    foreach ($hero_fields as $key => $field) {
        $wp_customize->add_setting($key, ['default' => $field['default'], 'sanitize_callback' => 'sanitize_text_field']);
        $wp_customize->add_control($key, [
            'label'   => $field['label'],
            'section' => 'vadim_hero',
            'type'    => 'text',
        ]);
    }

    // Stats Section
    $wp_customize->add_section('vadim_stats', [
        'title'    => __('Stats Bar', 'vadim-business'),
        'priority' => 31,
    ]);

    for ($i = 1; $i <= 3; $i++) {
        $wp_customize->add_setting("stat_{$i}_num", ['default' => '', 'sanitize_callback' => 'sanitize_text_field']);
        $wp_customize->add_control("stat_{$i}_num", ['label' => "Stat $i Number", 'section' => 'vadim_stats', 'type' => 'text']);
        $wp_customize->add_setting("stat_{$i}_label", ['default' => '', 'sanitize_callback' => 'sanitize_text_field']);
        $wp_customize->add_control("stat_{$i}_label", ['label' => "Stat $i Label", 'section' => 'vadim_stats', 'type' => 'text']);
    }

    // Contact Section
    $wp_customize->add_section('vadim_contact', [
        'title'    => __('Contact / CTA', 'vadim-business'),
        'priority' => 35,
    ]);

    $contact_fields = [
        'cta_title' => ['label' => 'CTA Title', 'default' => 'Ready to discuss your project?'],
        'cta_text'  => ['label' => 'CTA Text', 'default' => 'Write to us — we respond within an hour'],
        'cta_btn_text' => ['label' => 'CTA Button Text', 'default' => 'Contact Us'],
        'cta_btn_url'  => ['label' => 'CTA Button URL', 'default' => '#'],
        'contact_email' => ['label' => 'Email', 'default' => ''],
        'contact_telegram' => ['label' => 'Telegram', 'default' => ''],
        'contact_phone' => ['label' => 'Phone', 'default' => ''],
    ];

    foreach ($contact_fields as $key => $field) {
        $wp_customize->add_setting($key, ['default' => $field['default'], 'sanitize_callback' => 'sanitize_text_field']);
        $wp_customize->add_control($key, ['label' => $field['label'], 'section' => 'vadim_contact', 'type' => 'text']);
    }

    // Colors
    $wp_customize->add_setting('primary_color', ['default' => '#0B2559', 'sanitize_callback' => 'sanitize_hex_color']);
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'primary_color', [
        'label'   => 'Primary Color',
        'section' => 'colors',
    ]));
    $wp_customize->add_setting('accent_color', ['default' => '#BF8A1E', 'sanitize_callback' => 'sanitize_hex_color']);
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'accent_color', [
        'label'   => 'Accent Color',
        'section' => 'colors',
    ]));
}
add_action('customize_register', 'vadim_customizer');

// Output custom colors
function vadim_custom_colors() {
    $primary = get_theme_mod('primary_color', '#0B2559');
    $accent  = get_theme_mod('accent_color', '#BF8A1E');
    echo "<style>:root{--primary:{$primary};--accent:{$accent}}</style>\n";
}
add_action('wp_head', 'vadim_custom_colors');

// === CUSTOM POST TYPE: SERVICES ===
function vadim_register_cpt() {
    register_post_type('service', [
        'labels' => [
            'name' => 'Services',
            'singular_name' => 'Service',
            'add_new_title' => 'Add Service',
        ],
        'public'       => true,
        'has_archive'  => false,
        'menu_icon'    => 'dashicons-grid-view',
        'supports'     => ['title', 'editor', 'thumbnail', 'custom-fields'],
        'show_in_rest' => true,
    ]);

    register_post_type('portfolio', [
        'labels' => [
            'name' => 'Portfolio',
            'singular_name' => 'Project',
        ],
        'public'       => true,
        'has_archive'  => false,
        'menu_icon'    => 'dashicons-portfolio',
        'supports'     => ['title', 'editor', 'thumbnail', 'custom-fields'],
        'show_in_rest' => true,
    ]);

    register_post_type('testimonial', [
        'labels' => [
            'name' => 'Testimonials',
            'singular_name' => 'Testimonial',
        ],
        'public'       => true,
        'has_archive'  => false,
        'menu_icon'    => 'dashicons-format-quote',
        'supports'     => ['title', 'editor', 'custom-fields'],
        'show_in_rest' => true,
    ]);
}
add_action('init', 'vadim_register_cpt');

// === WIDGETS ===
function vadim_widgets() {
    register_sidebar([
        'name'          => 'Footer Widget Area',
        'id'            => 'footer-widgets',
        'before_widget' => '<div class="footer-col">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4>',
        'after_title'   => '</h4>',
    ]);
}
add_action('widgets_init', 'vadim_widgets');
