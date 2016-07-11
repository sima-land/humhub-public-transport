<?php
humhub\modules\public_transport_map\Assets::register($this);

/**
 * Displaying route nodes and zooming on click.
 */
?>
<script>
    function mapZoom(id)
    {
        map.setView([nodeLatArr[id],nodeLngArr[id]], 13);
        marker[id].openPopup();
        return;
    }
</script>

<div id="nodes">
    <?php
        $startTime = new DateTime($schedule[$id]->start_at);
        $nodeTime = $startTime;
        for ($i = 0; $i < count($nodes); $i++)
        {
            if ($i > 0)
            {
                $interval = $routeNode[$id]->node_interval;
                $nodeTime->modify('+'.$interval.' minutes');
                echo "<button id=".$i." class='btn btn-primary' style='display:inline-block; margin: 5px 5px 5px 0px;padding: 5px 10px 5px 10px;' onclick='mapZoom(".$i.")'>".$nodes[$i]->name." - ".$nodeTime->format('H:i')."</button>";
            }else{
                echo "<button id=".$i." class='btn btn-primary' style='display:inline-block;margin: 5px 5px 5px 0px;padding: 5px 10px 5px 10px;' onclick='mapZoom(".$i.")'>".$nodes[$i]->name." - ".$startTime->format('H:i')."</button>";
            }
        }
        echo $this->render('routesOnMap', [
            'nodeNameArr'=>json_encode($nodeNameArr),
            'nodeLatArr'=>json_encode($nodeLatArr),
            'nodeLngArr'=>json_encode($nodeLngArr)
        ]);
    //var_dump($nodeNameArr);
    ?>
    <script>//alert('nodes.php');</script>
</div>
