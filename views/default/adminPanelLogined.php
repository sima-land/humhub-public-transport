<?php
humhub\modules\public_transport_map\Assets::register($this);
use yii\helpers\Html;

?>
<link rel="stylesheet" href="http://cdn.leafletjs.com/leaflet/v0.7.7/leaflet.css"/>
<script src="http://cdn.leafletjs.com/leaflet/v0.7.7/leaflet.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/i18n/jquery-ui-i18n.js"></script>

<div class="admin-panel container">
    <div class="col-lg-12">
        <h2>Добро пожаловать, <?= $admin[0]->name ?>!</h2>
        <?php


        //echo $this->render('mapCreate');

        /*var_dump(Html::encode($model->login));
        echo "<pre>";
        var_dump($admin);
        echo "</pre>";
    */
        ?>
        <div id="map" class="map"></div>
        <script>
            var adminMap = L.map('map', {
                center: [56.838287, 60.601628],
                zoom: 13
            });

            L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoibmVraXRob2NrZXk3NSIsImEiOiJjaXFpdzkwb20wMGJpaTZreDJkMmlodGI0In0.DxpGut-SRB5kFx9T-zQRpA', {
                attribution: 'Admin Map',
                maxZoom: 15,
                id: 'nekithockey75.0l1di5ip',
                accessToken: 'pk.eyJ1IjoibmVraXRob2NrZXk3NSIsImEiOiJjaXFpdzkwb20wMGJpaTZreDJkMmlodGI0In0.DxpGut-SRB5kFx9T-zQRpA'
            }).addTo(adminMap);

            adminMap.on('click', function (e) {
                L.marker(e.latlng).addTo(adminMap);
                var latlng = e.latlng;
                alert(latlng);
            });

        </script>
    </div>
</div>
