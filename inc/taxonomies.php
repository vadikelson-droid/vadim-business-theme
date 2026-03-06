<?php
/**
 * Custom Taxonomies
 */
function vadim_register_taxonomies() {
    register_taxonomy('portfolio_category', 'portfolio', [
        'labels' => [
            'name'          => 'Project Categories',
            'singular_name' => 'Category',
            'add_new_item'  => 'Add Category',
        ],
        'public'       => true,
        'hierarchical' => true,
        'show_in_rest' => true,
        'rewrite'      => ['slug' => 'project-category'],
    ]);

    register_taxonomy('service_category', 'service', [
        'labels' => [
            'name'          => 'Service Categories',
            'singular_name' => 'Category',
        ],
        'public'       => true,
        'hierarchical' => true,
        'show_in_rest' => true,
    ]);
}
add_action('init', 'vadim_register_taxonomies');
