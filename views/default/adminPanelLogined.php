<?php
humhub\modules\public_transport_map\Assets::register($this);
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<link rel="stylesheet" href="http://cdn.leafletjs.com/leaflet/v0.7.7/leaflet.css"/>
<script src="http://cdn.leafletjs.com/leaflet/v0.7.7/leaflet.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/i18n/jquery-ui-i18n.js"></script>

<div class="admin-panel container">
    <div class="col-lg-12">
        <h2>Добро пожаловать, <?= $admin[0]->name ?>!</h2><a id='exit-button' href="index.php?r=public_transport_map%2Fdefault%2Fadmin-panel">Выйти</a>



        <div class="row">
            <div class="col-lg-4">
                <?php
                $formNode = ActiveForm::begin([
                    'id' => 'login-form',
                    'options' => ['class' => 'form-horizontal'],
                ]);
                ?>

                <?= $formNode->field($newNode, 'newLat')->textInput(); ?>
                <?= $formNode->field($newNode, 'newLng')->textInput(); ?>
                <?= $formNode->field($newNode, 'newName')->textInput(); ?>

                <?= Html::submitButton('Добавить', ['class' => 'btn btn-primary']) ?>

                <div style="color: indianred; margin-top: 20px;"></div>

                <?php
                ActiveForm::end();
                ?>
            </div>

        </div>




        <div id="map-admin" class="map"></div>



        <script>
            var adminMap = L.map('map-admin', {
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
                $('#ptmnode-newlat').val(latlng.lat);
                $('#ptmnode-newlng').val(latlng.lng);
            });

        </script>
    </div>
</div>
