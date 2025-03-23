<?php
add_action('admin_menu', function() {
    add_menu_page('DC Interconnect', 'DC Interconnect', 'manage_options', 'mdc-admin', 'mdc_admin_page');
});

function mdc_admin_page() {
?>
<div class="wrap">
    <h2>Manage Data Centers</h2>
    <table>
        <thead>
            <tr><th>DC Name & Capacity</th><th>X (lat)</th><th>Y (lng)</th><th>Size</th><th>Action</th></tr>
        </thead>
        <tbody id="node-list"></tbody>
    </table>
    <form id="mdc-node-form">
        <input type="text" name="name" placeholder="Data Center Name + Capacity" required>
        <input type="number" name="lat" placeholder="X" required>
        <input type="number" name="lng" placeholder="Y" required>
        <input type="number" name="size" placeholder="Node Size" required>
        <button type="submit">Add Node</button>
    </form>

    <h2>Manage Connections</h2>
    <table>
        <thead>
            <tr><th>From</th><th>To</th><th>Load</th><th>Speed</th><th>Action</th></tr>
        </thead>
        <tbody id="conn-list"></tbody>
    </table>
    <form id="mdc-connection-form">
        <input type="text" name="from" placeholder="From Node" required>
        <input type="text" name="to" placeholder="To Node" required>
        <input type="number" name="load" placeholder="Bandwidth Load" required>
        <input type="number" name="speed" placeholder="Flow Speed" value="5">
        <button type="submit">Add Connection</button>
    </form>
</div>

<script>
jQuery(function($){
    function loadData() {
        $.post(mdc_ajax.ajax_url, {action: 'mdc_get_all'}, function(res) {
            let nodeHtml = res.data.nodes.map((n, i) => `<tr>
                <td>${n.name}</td><td>${n.lat}</td><td>${n.lng}</td><td>${n.size}</td>
                <td><button onclick="removeNode(${i})">Remove</button></td></tr>`).join('');
            $('#node-list').html(nodeHtml);

            let connHtml = res.data.connections.map((c, i) => `<tr>
                <td>${c.from}</td><td>${c.to}</td><td>${c.load}</td><td>${c.speed}</td>
                <td><button onclick="removeConn(${i})">Remove</button></td></tr>`).join('');
            $('#conn-list').html(connHtml);
        });
    }
    loadData();

    $('#mdc-node-form').on('submit', function(e){
        e.preventDefault();
        $.post(mdc_ajax.ajax_url, $(this).serialize() + '&action=mdc_save_node', function(res){
            alert(res.success ? 'Node Added' : 'Fail');
            loadData();
        });
    });

    $('#mdc-connection-form').on('submit', function(e){
        e.preventDefault();
        $.post(mdc_ajax.ajax_url, $(this).serialize() + '&action=mdc_save_connection', function(res){
            alert(res.success ? 'Connection Added' : 'Fail');
            loadData();
        });
    });

    window.removeNode = function(index) {
        $.post(mdc_ajax.ajax_url, {action: 'mdc_remove_node', index: index}, function(res){
            alert(res.success ? 'Node Removed' : 'Fail');
            loadData();
        });
    }

    window.removeConn = function(index) {
        $.post(mdc_ajax.ajax_url, {action: 'mdc_remove_connection', index: index}, function(res){
            alert(res.success ? 'Connection Removed' : 'Fail');
            loadData();
        });
    }
});
</script>
<?php }
?>
