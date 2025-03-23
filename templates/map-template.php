<?php
$nodes = get_option('mdc_nodes', []);
$connections = get_option('mdc_connections', []);
?>
<style>
.dc-node { fill: #3498db; stroke: #fff; stroke-width: 2px; cursor: pointer; }
.dc-line { stroke-width: 3px; fill: none; animation: dash linear infinite; }
.dc-label { fill: #333; font-size: 14px; text-anchor: middle; }
@keyframes dash { to { stroke-dashoffset: -1000; } }
</style>
<svg width="1000" height="800" style="border:1px solid #ccc; background:url('https://upload.wikimedia.org/wikipedia/commons/3/3b/Malaysia_location_map.svg') no-repeat center/contain;">
<?php foreach($nodes as $node): ?>
    <circle class="dc-node" r="<?php echo $node['size']; ?>" cx="<?php echo $node['lat']; ?>" cy="<?php echo $node['lng']; ?>">
        <title><?php echo $node['name']; ?></title>
    </circle>
    <text class="dc-label" x="<?php echo $node['lat']; ?>" y="<?php echo $node['lng'] - 15; ?>"><?php echo $node['name']; ?></text>
<?php endforeach; ?>

<?php foreach($connections as $conn):
    $from = array_filter($nodes, fn($n) => $n['name'] === $conn['from']);
    $to = array_filter($nodes, fn($n) => $n['name'] === $conn['to']);
    if ($from && $to):
        $f = array_values($from)[0];
        $t = array_values($to)[0];
        $color = ($conn['load'] > 700) ? 'red' : (($conn['load'] > 400) ? 'orange' : 'green');
?>
    <line class="dc-line" x1="<?php echo $f['lat']; ?>" y1="<?php echo $f['lng']; ?>" 
          x2="<?php echo $t['lat']; ?>" y2="<?php echo $t['lng']; ?>"
          stroke="<?php echo $color; ?>" stroke-dasharray="10,10"
          style="animation-duration: <?php echo $conn['speed']; ?>s;" />
<?php endif; endforeach; ?>
</svg>
