<?php
/**
 * Custom Meta Boxes (no ACF dependency)
 */

// === PORTFOLIO META BOX ===
function vadim_portfolio_meta_boxes() {
    add_meta_box('vadim_portfolio_details', 'Project Details', 'vadim_portfolio_meta_cb', 'portfolio', 'normal', 'high');
    add_meta_box('vadim_testimonial_details', 'Client Details', 'vadim_testimonial_meta_cb', 'testimonial', 'normal', 'high');
    add_meta_box('vadim_service_details', 'Service Details', 'vadim_service_meta_cb', 'service', 'normal', 'high');
}
add_action('add_meta_boxes', 'vadim_portfolio_meta_boxes');

function vadim_portfolio_meta_cb($post) {
    wp_nonce_field('vadim_portfolio_nonce', 'vadim_portfolio_nonce_field');
    $fields = [
        'project_url'    => ['label' => 'Project URL', 'type' => 'url'],
        'technologies'   => ['label' => 'Technologies (comma separated)', 'type' => 'text'],
        'project_year'   => ['label' => 'Year', 'type' => 'text'],
        'project_client' => ['label' => 'Client Name', 'type' => 'text'],
        'project_status' => ['label' => 'Status', 'type' => 'select', 'options' => ['live' => 'Live', 'demo' => 'Demo', 'pitch' => 'Pitch', 'production' => 'Production']],
    ];
    vadim_render_meta_fields($post, $fields);
}

function vadim_testimonial_meta_cb($post) {
    wp_nonce_field('vadim_testimonial_nonce', 'vadim_testimonial_nonce_field');
    $fields = [
        'client_role'    => ['label' => 'Client Role / Company', 'type' => 'text'],
        'client_rating'  => ['label' => 'Rating (1-5)', 'type' => 'number'],
        'client_url'     => ['label' => 'Client Website', 'type' => 'url'],
    ];
    vadim_render_meta_fields($post, $fields);
}

function vadim_service_meta_cb($post) {
    wp_nonce_field('vadim_service_nonce', 'vadim_service_nonce_field');
    $fields = [
        'service_icon'  => ['label' => 'Icon (emoji or dashicon class)', 'type' => 'text'],
        'service_color' => ['label' => 'Color Scheme', 'type' => 'select', 'options' => ['blue' => 'Blue', 'gold' => 'Gold']],
        'service_price' => ['label' => 'Starting Price', 'type' => 'text'],
    ];
    vadim_render_meta_fields($post, $fields);
}

// Render helper
function vadim_render_meta_fields($post, $fields) {
    echo '<table class="form-table"><tbody>';
    foreach ($fields as $key => $f) {
        $val = get_post_meta($post->ID, $key, true);
        echo '<tr><th><label for="' . esc_attr($key) . '">' . esc_html($f['label']) . '</label></th><td>';
        if ($f['type'] === 'select') {
            echo '<select name="' . esc_attr($key) . '" id="' . esc_attr($key) . '">';
            foreach ($f['options'] as $k => $v) {
                echo '<option value="' . esc_attr($k) . '"' . selected($val, $k, false) . '>' . esc_html($v) . '</option>';
            }
            echo '</select>';
        } elseif ($f['type'] === 'textarea') {
            echo '<textarea name="' . esc_attr($key) . '" id="' . esc_attr($key) . '" rows="4" class="large-text">' . esc_textarea($val) . '</textarea>';
        } else {
            echo '<input type="' . esc_attr($f['type']) . '" name="' . esc_attr($key) . '" id="' . esc_attr($key) . '" value="' . esc_attr($val) . '" class="regular-text">';
        }
        echo '</td></tr>';
    }
    echo '</tbody></table>';
}

// Save meta
function vadim_save_portfolio_meta($post_id) {
    $nonces = ['vadim_portfolio_nonce_field' => 'vadim_portfolio_nonce', 'vadim_testimonial_nonce_field' => 'vadim_testimonial_nonce', 'vadim_service_nonce_field' => 'vadim_service_nonce'];
    $valid = false;
    foreach ($nonces as $field => $action) {
        if (isset($_POST[$field]) && wp_verify_nonce($_POST[$field], $action)) {
            $valid = true;
            break;
        }
    }
    if (!$valid) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;

    $meta_keys = ['project_url', 'technologies', 'project_year', 'project_client', 'project_status', 'client_role', 'client_rating', 'client_url', 'service_icon', 'service_color', 'service_price'];
    foreach ($meta_keys as $key) {
        if (isset($_POST[$key])) {
            update_post_meta($post_id, $key, sanitize_text_field($_POST[$key]));
        }
    }
}
add_action('save_post', 'vadim_save_portfolio_meta');
