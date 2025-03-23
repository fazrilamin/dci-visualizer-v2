<?php
/*
Plugin Name: Malaysia Data Center Interconnect
Description: Visualize Malaysia Data Center Interconnects with animated SVG and admin panel.
Version: 1.0
Author: Fazril Amin
*/

add_action('admin_enqueue_scripts', function() {
    wp_enqueue_script('mdc-script', plugins_url('js/interconnect.js', __FILE__), ['jquery'], false, true);
    wp_enqueue_style('mdc-style', plugins_url('css/interconnect.css', __FILE__));
    wp_localize_script('mdc-script', 'mdc_ajax', ['ajax_url' => admin_url('admin-ajax.php')]);
});

include_once plugin_dir_path(__FILE__) . 'includes/admin-panel.php';
include_once plugin_dir_path(__FILE__) . 'includes/ajax-handlers.php';

add_shortcode('malaysia_dc_map', function() {
    ob_start();
    include plugin_dir_path(__FILE__) . 'templates/map-template.php';
    return ob_get_clean();
});

function dci_map_shortcode() {
    ob_start();
    include plugin_dir_path(__FILE__) . 'templates/map-template.php';
    return ob_get_clean();
}
add_shortcode('dci_map', 'dci_map_shortcode');

?>
