<?php
add_action('wp_ajax_mdc_save_node', function() {
    $nodes = get_option('mdc_nodes', []);
    $nodes[] = [
        'name' => sanitize_text_field($_POST['name']),
        'lat' => floatval($_POST['lat']),
        'lng' => floatval($_POST['lng']),
        'size' => intval($_POST['size'])
    ];
    update_option('mdc_nodes', $nodes);
    wp_send_json_success();
});

add_action('wp_ajax_mdc_remove_node', function() {
    $nodes = get_option('mdc_nodes', []);
    $index = intval($_POST['index']);
    if (isset($nodes[$index])) { array_splice($nodes, $index, 1); }
    update_option('mdc_nodes', $nodes);
    wp_send_json_success();
});

add_action('wp_ajax_mdc_save_connection', function() {
    $connections = get_option('mdc_connections', []);
    $connections[] = [
        'from' => sanitize_text_field($_POST['from']),
        'to' => sanitize_text_field($_POST['to']),
        'load' => intval($_POST['load']),
        'speed' => intval($_POST['speed'])
    ];
    update_option('mdc_connections', $connections);
    wp_send_json_success();
});

add_action('wp_ajax_mdc_remove_connection', function() {
    $connections = get_option('mdc_connections', []);
    $index = intval($_POST['index']);
    if (isset($connections[$index])) { array_splice($connections, $index, 1); }
    update_option('mdc_connections', $connections);
    wp_send_json_success();
});

add_action('wp_ajax_mdc_get_all', function() {
    wp_send_json_success([
        'nodes' => get_option('mdc_nodes', []),
        'connections' => get_option('mdc_connections', [])
    ]);
});
?>
