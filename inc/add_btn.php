<?php
// Add Button in Header
function dc1_add_button_to_header() {
    // Check if the button should be active
    if (!get_option('dc1_button_active')) {
        return;
    }

    // Button Properties
    $button_title = 'Dashboard Login';
    $button_url = DC1_PLUGIN_URL . 'templates/custom-login.php';
    $button_color = '#fff';
    $button_bg_color = '#007BFF';

    // Display Button
    echo '<a style="position: fixed; top: 10px; right: 10px; z-index: 9999; padding: 10px 20px; text-decoration: none; color: '
         . esc_attr($button_color) . '; background: ' . esc_attr($button_bg_color) 
         . '; border-radius: 5px;" href="' . esc_url($button_url) . '" target="_self">' . esc_html($button_title) . '</a>';
}
add_action('wp_head', 'dc1_add_button_to_header');
