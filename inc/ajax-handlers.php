<?php
/**
 * AJAX Handlers — Portfolio Filter & Live Search
 */

// === AJAX PORTFOLIO FILTER ===
function vadim_ajax_portfolio_filter() {
    check_ajax_referer('vadim_ajax_nonce', 'nonce');

    $category = sanitize_text_field($_POST['category'] ?? 'all');

    $args = [
        'post_type'      => 'portfolio',
        'posts_per_page' => 12,
        'orderby'        => 'menu_order',
        'order'          => 'ASC',
    ];

    if ($category !== 'all') {
        $args['tax_query'] = [[
            'taxonomy' => 'portfolio_category',
            'field'    => 'slug',
            'terms'    => $category,
        ]];
    }

    $query = new WP_Query($args);
    $html = '';

    if ($query->have_posts()) {
        $idx = 0;
        while ($query->have_posts()) {
            $query->the_post();
            $link   = get_post_meta(get_the_ID(), 'project_url', true);
            $techs  = get_post_meta(get_the_ID(), 'technologies', true);
            $status = get_post_meta(get_the_ID(), 'project_status', true);

            $tag_open  = $link ? '<a href="' . esc_url($link) . '" target="_blank"' : '<div';
            $tag_close = $link ? '</a>' : '</div>';

            $html .= $tag_open . ' class="portfolio-card' . ($idx === 0 ? ' featured' : '') . ' rv vis">';

            if (has_post_thumbnail()) {
                $html .= '<div class="portfolio-img">' . get_the_post_thumbnail(get_the_ID(), 'portfolio-thumb') . '</div>';
            }

            $html .= '<div class="portfolio-body">';
            $html .= '<h3>' . get_the_title() . '</h3>';
            $html .= '<p>' . wp_trim_words(get_the_excerpt(), 25) . '</p>';

            if ($techs) {
                $html .= '<div class="tags">';
                foreach (explode(',', $techs) as $t) {
                    $html .= '<span class="tag">' . esc_html(trim($t)) . '</span>';
                }
                $html .= '</div>';
            }

            if ($status) {
                $html .= '<span class="portfolio-status status-' . esc_attr($status) . '">' . esc_html(ucfirst($status)) . '</span>';
            }

            $html .= '</div>';
            $html .= $tag_close;
            $idx++;
        }
    } else {
        $html = '<p class="no-results">No projects found in this category.</p>';
    }

    wp_reset_postdata();
    wp_send_json_success(['html' => $html, 'count' => $query->found_posts]);
}
add_action('wp_ajax_vadim_portfolio_filter', 'vadim_ajax_portfolio_filter');
add_action('wp_ajax_nopriv_vadim_portfolio_filter', 'vadim_ajax_portfolio_filter');

// === AJAX LIVE SEARCH ===
function vadim_ajax_live_search() {
    check_ajax_referer('vadim_ajax_nonce', 'nonce');

    $search = sanitize_text_field($_POST['query'] ?? '');
    if (strlen($search) < 2) {
        wp_send_json_success(['results' => []]);
    }

    $args = [
        'post_type'      => ['post', 'page', 'portfolio', 'service'],
        'posts_per_page' => 8,
        's'              => $search,
        'post_status'    => 'publish',
    ];

    $query = new WP_Query($args);
    $results = [];

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $results[] = [
                'id'        => get_the_ID(),
                'title'     => get_the_title(),
                'url'       => get_permalink(),
                'type'      => get_post_type(),
                'excerpt'   => wp_trim_words(get_the_excerpt(), 12),
                'thumbnail' => get_the_post_thumbnail_url(get_the_ID(), 'thumbnail') ?: '',
            ];
        }
    }

    wp_reset_postdata();
    wp_send_json_success(['results' => $results]);
}
add_action('wp_ajax_vadim_live_search', 'vadim_ajax_live_search');
add_action('wp_ajax_nopriv_vadim_live_search', 'vadim_ajax_live_search');
