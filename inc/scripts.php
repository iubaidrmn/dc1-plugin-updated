<?php

// Enqueue Scripts and Styles
function dc1_enqueue_scripts() {
    wp_enqueue_style('dc1-styles', DC1_PLUGIN_URL . 'assets/css/styles.css', [], DC1_VERSION);
    // wp_enqueue_script('dc1-scripts', DC1_PLUGIN_URL . 'assets/js/scripts.js', ['jquery'], DC1_VERSION, true);
}
add_action('wp_enqueue_scripts', 'dc1_enqueue_scripts');
