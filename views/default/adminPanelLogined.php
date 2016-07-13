<?php
humhub\modules\public_transport_map\Assets::register($this);
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<link rel="stylesheet" href="http://cdn.leafletjs.com/leaflet/v0.7.7/leaflet.css"/>
<script src="http://cdn.leafletjs.com/leaflet/v0.7.7/leaflet.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/i18n/jquery-ui-i18n.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/i18n/jquery-ui-i18n.js"></script>

<div class="admin-panel container">
    <div class="col-lg-12">
        <h2>Добро пожаловать, <?= '%admin_name%'//$_SESSION['admin'];   ?>!</h2><a id='exit-button'
                                                                                   href="index.php?r=public_transport_map%2Fdefault%2Fadmin-panel">Выйти</a>


        <div class="row">
            <div class="col-lg-4">


                <?php
                $formNode = ActiveForm::begin([
                    'id' => 'login-form',
                    'options' => ['class' => 'form-horizontal']
                ]);
                ?>

                <?= $formNode->field($newNode, 'newLat')->textInput(); ?>
                <?= $formNode->field($newNode, 'newLng')->textInput(); ?>
                <?= $formNode->field($newNode, 'newName')->textInput(); ?>

                <?= Html::submitButton('Добавить остановку', ['class' => 'btn btn-primary']) ?>

                <div id="delete-last">Удалить последнюю ( надо тестить )</div>


                <?php

                echo "<pre>";
                var_dump($names);
                echo "</pre>";

                if (!isset($names)) $names = '';
                ?>


                <?php
                ActiveForm::end();
                ?>

                <div class="node-cards"></div>

            </div>

            <div class="col-lg-1"></div>

            <div class="col-lg-4">
                <?php
                $formRoute = ActiveForm::begin([
                    'id' => 'login-form',
                    'options' => ['class' => 'form-horizontal']
                ]);
                ?>

                <?= $formRoute->field($newRoute, 'newTitle')->textInput(); ?>
                <?= $formRoute->field($newRoute, 'newDirectionID')->dropDownList([
                    '1' => 'на работу',
                    '2' => 'с работы'
                ]); ?>

                <?= Html::submitButton('Добавить маршрут', ['class' => 'btn btn-primary']) ?>

                <div style="color: indianred; margin-top: 20px;">Удалить ( пока не работает )</div>

                <?php
                ActiveForm::end();
                ?>
            </div>

            <!--<div class="col-lg-3">
                <form name="form-test" action="" method="post">
                    <input name="routeName" type="text" />
                    <select name="direction" id="direction-input">
                        <option value="1">На работу</option>
                        <option value="2">С работы</option>
                    </select>
                </form>
            </div>-->


        </div>

    </div>


    <div id="map-admin" class="map"></div>-->


    <script>
        $(document).ready(function () {
            var newName = '';
            newName = "<?=$names?>";

            if (newName != '' && newName != null) {//it collects names of new nodes
                //alert('newName != null');
                if (getItemFromLocalStorage('names').length != 0) {
                    addItemToLocalStorage(newName, 'names');
                } else {
                    initLocalStorage('names');
                    addItemToLocalStorage(newName, 'names');
                }
            }
            else {
                //alert('init');
                initLocalStorage('names');
            }

            //alert(getItemFromLocalStorage('names').length);

            for (var i = 0; i < getItemFromLocalStorage('names').length; i++) {//show added node cards
                //alert('k');
                $('.node-cards').append("<div class='node-card-item'>" + getItemFromLocalStorage('names')[i] + "</div>")
            }
        });

        $('#delete-last').on('click', function () {//now it will delete all cards
            initLocalStorage('names');

            $('.node-card-item').remove();
        });

        $('&times').on('click', function () {
            alert('l');
        });

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

        L.Routing.control({
            waypoints: [
                L.latLng(57.74, 11.94),
                L.latLng(57.6792, 11.949)
            ]
        }).addTo(adminMap);

        function addItemToLocalStorage(item, index) {
            var temp = JSON.parse(localStorage.getItem(index));
            if (temp == '') {
                localStorage.setItem(index, JSON.stringify([]));
                temp.push(item);
                var tempItem = JSON.stringify(temp);
                localStorage.setItem(index, tempItem);
            } else {
                temp.push(item);
                var tempItem = JSON.stringify(temp);
                localStorage.setItem(index, tempItem);
            }
        }

        function getItemFromLocalStorage(index) {
            var temp = JSON.parse(localStorage.getItem(index));
            return temp;
        }

        function initLocalStorage(index) {
            localStorage.setItem(index, JSON.stringify([]));
        }

    </script>
</div>
</div>
