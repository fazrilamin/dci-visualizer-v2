<?php
/*
Plugin Name: DCI Visualizer v2
Description: Visualize Data Centre Interconnect with animated flow lines on a real map
Version: 2.0
Author: Fazril Amin
*/

if (!defined('ABSPATH')) exit; // Exit if accessed directly

// Enqueue scripts and styles
function dci_visualizer_assets() {
    wp_enqueue_style('leaflet-css', 'https://unpkg.com/leaflet/dist/leaflet.css');
    wp_enqueue_style('dci-style', plugin_dir_url(__FILE__) . 'assets/style.css');

    wp_enqueue_script('leaflet-js', 'https://unpkg.com/leaflet/dist/leaflet.js', [], false, true);
    wp_enqueue_script('dci-script', plugin_dir_url(__FILE__) . 'assets/script.js', array('leaflet-js'), false, true);

    // Pass PHP data to JS (optional)
    wp_localize_script('dci-visualizer-js', 'dci_vars', [
    'datacenters' => json_decode(get_option('dci_datacenters', '[]')),
]);

}
add_action('wp_enqueue_scripts', 'dci_visualizer_assets');

// Shortcode
function dci_visualizer_shortcode() {
    ob_start(); ?>
    <div id="dci-map" style="height: 600px;"></div>
    <?php
    return ob_get_clean();
}
add_shortcode('dci_animation_v2', 'dci_visualizer_shortcode');

// Include settings page
require_once plugin_dir_path(__FILE__) . 'includes/settings-page.php';