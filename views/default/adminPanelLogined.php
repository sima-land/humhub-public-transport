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

                <div id="delete-last">Удалить все</div>


                <?php

                echo "<pre>";
                var_dump($newNode->newName);
                var_dump($newNode->newLat);
                var_dump($newNode->newLng);
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
                    'id' => 'route-form',
                    'options' => ['class' => 'form-horizontal']
                ]);
                ?>

                <?= $formRoute->field($newRoute, 'newTitle')->textInput(); ?>
                <?= $formRoute->field($newRoute, 'newDirectionID')->dropDownList([
                    '1' => 'На работу',
                    '2' => 'С работы'
                ])?>

                <div class="btn btn-primary" id="add-route">Добавить маршрут</div>

                <?php ActiveForm::end(); ?>
            </div>


        </div>

    </div>


    <div id="map1" class="map1"></div>


    <script>
        $(document).ready(function () {
            var newName = ''; newName = "<?=$newNode->newName?>";
            var newLat = ''; newLat = "<?=$newNode->newLat?>";
            var newLng = ''; newLng = "<?=$newNode->newLng?>";
            var newNode = [newName, newLat, newLng];// Node

            if (newName != '' && newName != null) {//it collects names of new nodes
                if (getItemFromLocalStorage('nodes').length != 0) {
                    addItemToLocalStorage(newNode, 'nodes');
                } else {
                    initLocalStorage('nodes');
                    addItemToLocalStorage(newNode, 'nodes');
                }
            }
            else {
                initLocalStorage('nodes');
            }

            for (var i = 0; i < getItemFromLocalStorage('nodes').length; i++) {//show added node cards
                $('.node-cards').append("<div class='node-card-item'>" + getItemFromLocalStorage('nodes')[i][0] + "</div>")
            }
        });
//request to controller for adding to DB
        $('#add-route').on('click', function () {

            var newNameArray = []; var newLatArray = []; var newLngArray = [];
            var newDirection = $('#ptmroute-newdirectionid').val();
            var newTitle = $('#ptmroute-newtitle').val();

            for (var i = 0; i < getItemFromLocalStorage('nodes').length; i++) {
                newNameArray.push(getItemFromLocalStorage('nodes')[i][0]);
                newLatArray.push(getItemFromLocalStorage('nodes')[i][1]);
                newLngArray.push(getItemFromLocalStorage('nodes')[i][2]);
            }

            alert(newNameArray[0]   );

            $.ajax({
                type: 'GET',
                url: 'index.php?r=public_transport_map%2Fdefault%2Fadd-route&nodeNamesReady=' + JSON.stringify(newNameArray) + '&nodeLatReady=' + JSON.stringify(newLatArray) + '&nodeLngReady=' + JSON.stringify(newLngArray) + '&routeDirection=' + newDirection + '&routeTitle=' + newTitle,
                success: function (data) {
                    alert(data);
                },
                error: function () {
                    alert('Ошибка. Данные не отправлены.');
                }
            })
        });

        $('#delete-last').on('click', function () {//now it deletes all cards
            initLocalStorage('nodes');

            $('.node-card-item').remove();
        });
//map script
        var adminMap = L.map('map1', {
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

//here we need a local storage to collect all nodes ( it gives an opportunity to delete garbage nodes for admin )
        function addItemToLocalStorage(itemName, index) {
            var temp = JSON.parse(localStorage.getItem(index));
            if (temp == '') {
                localStorage.setItem(index, JSON.stringify([]));
                temp.push(itemName);
                var tempItem = JSON.stringify(temp);
                localStorage.setItem(index, tempItem);
            } else {
                temp.push(itemName);
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
