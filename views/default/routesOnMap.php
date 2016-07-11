<?php
humhub\modules\public_transport_map\Assets::register($this);

/**
 * JSON parsing and map initialization.
 */
?>

<script>
var nodeNameArr = JSON.parse(<?php echo $nodeNameArr ?>);
var nodeLatArr = JSON.parse(<?php echo $nodeLatArr ?>);
var nodeLngArr = JSON.parse(<?php echo $nodeLngArr ?>);

//alert('routesOnMap.php  ');

$(function () {
    start(nodeNameArr, nodeLatArr, nodeLngArr);
    map.on('click', function(e) {
        L.marker(e.latlng).addTo(map);
    });
})
</script>
