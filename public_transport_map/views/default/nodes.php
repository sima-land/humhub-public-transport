<!--suppress ALL -->
<script>
    function mapZoom(id) {
        map.setView([nodeLatArr[id],nodeLngArr[id]], 15);
        marker[id].openPopup();
        return;
    }

</script>

<div class="panel-heading"><?= $schedule[$id]->route->direction->description; ?></div>

<div>
<?php

$timeNotFormat = date_create($schedule[$id]->start_at);
$time = date_format($timeNotFormat, 'H:i');
$intTime = 0;
$addHours =0;
$addMinutes = 0;
for ($i=0;$i<count($nodes);$i++) {
    if ($i>0) {
        //$addHours = ($addHours + $routeNode[$i]->node_interval / 60).":00";
        //$addMinutes = "00:".($addMinutes + $routeNode[$i]->node_interval% 60);

        if ($routeNode[$i]->node_interval <60) {
            $intTime = "00:".$routeNode[$i]->node_interval;
            $intNofFormat = date_create($intTime);
            $interval = date_format($intNofFormat, 'H:i') ;
            $nodeTime = date("H:i", strtotime($time) + strtotime($interval));

            echo "<button class='btn btn-primary' style='display:inline-block; margin: 15px 5px 5px 5px;padding: 10px 15px 10px 15px;' onclick='mapZoom(".$i.")'>".$nodes[$i]->name." - ".$nodeTime."</button>";
        }elseif ($routeNode[$i]->node_interval >=60 and $routeNode[$i]->node_interval <120) {

        }
    }else {
            echo "<button class='btn btn-primary' style='display:inline-block;margin: 15px 5px 5px 5px;padding: 10px 15px 10px 15px;' onclick='mapZoom(" . $i . ")'>" . $nodes[$i]->name ." - ".$time. "</button>";

    }

}
?>
</div>
