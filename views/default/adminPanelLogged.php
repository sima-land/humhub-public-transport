<?php
humhub\modules\public_transport_map\Assets::register($this);
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use humhub\modules\user\models\User;

?>
<link rel="stylesheet" href="http://cdn.leafletjs.com/leaflet/v0.7.7/leaflet.css"/>
<script src="http://cdn.leafletjs.com/leaflet-0.7.3/leaflet.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/i18n/jquery-ui-i18n.js"></script>

<div class="admin-panel container">
    <div class="col-lg-12">
        <h2 style="margin-left: 10%; margin-bottom: 20px; ">Добро
            пожаловать <?= User::findOne(Yii::$app->user->id)->username; ?>!</h2><a id='exit-button'
                                                                                    href="index.php?r=public_transport_map%2Fdefault%2Findex">Выйти</a>


        <div class="row">

            <div class="col-lg-1"></div>

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
                <?= $formNode->field($newNode, 'newNodeInterval')->textInput(); ?>

                <?= Html::submitButton('Добавить остановку', ['class' => 'btn btn-primary']) ?>



                <?php
                ActiveForm::end();
                ?>
                <?php
                if (!isset($names)) $names = '';
                ?>
                <div id="delete-last">Удалить все</div>
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
                ]) ?>

                <div class="btn btn-primary" id="add-route">Добавить маршрут</div>

                <?php ActiveForm::end(); ?>
            </div>


            <div class="col-lg-2"></div>


        </div>

    </div>


    <div class="row">
        <div class="col-lg-12"><a href="index.php?r=public_transport_map%2Fdefault%2Fadmin-panel&adminDBPanel=true"
                                  target="_blank">Перейти к редактированию таблиц.</a></div>
    </div>

    <div id="map1" class="map1"></div>


    <script>

        $(document).ready(function () {

            //$('input').val('');

            $('#ptmnode-newnodeinterval').mask("99:99");//it is a mask for the time input


            //getting parameters of new nodes from controller vars

            var newName = '';
            newName = "<?=$newNode->newName?>";
            var newLat = '';
            newLat = "<?=$newNode->newLat?>";
            var newLng = '';
            newLng = "<?=$newNode->newLng?>";
            var newTime = '';
            newTime = "<?=$newNode->newNodeInterval?>";//newTime should get a datatime object

            var newNode = [newName, newLat, newLng, newTime];// Node

            if (newName != '' && newName != null) {//it collects names of new nodes
                if (getItemFromLocalStorage('node').length != 0) {
                    addItemToLocalStorage(newNode, 'node');
                } else {
                    initLocalStorage('node');
                    addItemToLocalStorage(newNode, 'node');
                }
            }
            else {
                initLocalStorage('node');
            }

            for (var i = 0; i < getItemFromLocalStorage('node').length; i++) {//show added node cards
                $('.node-cards').append("<div class='node-card-item'>" + getItemFromLocalStorage('node')[i][0] + ' ' + getItemFromLocalStorage('node')[i][3] + "</div>")
            }

            //here will be redrawing a route in case of adding new node

            var name = [];
            var lat = [];
            var lng = [];

            for (var j = 0; j < getItemFromLocalStorage('node').length; j++) {
                name.push(getItemFromLocalStorage('node')[j][0]);
                lat.push(getItemFromLocalStorage('node')[j][1]);
                lng.push(getItemFromLocalStorage('node')[j][2]);
            }


            start(name, lat, lng, true);

            /*
             var marker1 = new L.FeatureGroup();
             for (var k = 0; k < getItemFromLocalStorage('node').length; k++) {
             var marker2 = new L.Marker([getItemFromLocalStorage('node')[k][1], getItemFromLocalStorage('node')[k][2]]).addTo(adminMap);
             marker.addLayer(marker2);
             }
             adminMap.addLayer(marker);*/
        });

        //request to controller for adding to DB

        $('#add-route').on('click', function () {

            var newNameArray = [];
            var newLatArray = [];
            var newLngArray = [];
            var newTimeArray = [];
            var newDirection = $('#ptmroute-newdirectionid').val();
            var newTitle = $('#ptmroute-newtitle').val();

            for (var i = 0; i < getItemFromLocalStorage('node').length; i++) {
                newNameArray.push(getItemFromLocalStorage('node')[i][0]);
                newLatArray.push(getItemFromLocalStorage('node')[i][1]);
                newLngArray.push(getItemFromLocalStorage('node')[i][2]);
                var interval = toMinutes(toDate(getItemFromLocalStorage('node')[i][3]) - toDate(getItemFromLocalStorage('node')[0][3]));
                if (interval <= newTimeArray[i - 1]) {
                    initLocalStorage('node');
                    alert('Время введено неправильно (Скорее всего нарушено возрастание).');
                    return;
                }
                newTimeArray.push(interval);//here is an intervals between nodes interval of (0 -> x) = time2-time1, interval of 1st stop is 0
            }

            //alert(newTimeArray);

            $.ajax({
                type: 'GET',
                url: 'index.php?r=public_transport_map%2Fdefault%2Fadd-route&nodeNamesReady=' + JSON.stringify(newNameArray) + '&nodeLatReady=' + JSON.stringify(newLatArray) + '&nodeLngReady=' + JSON.stringify(newLngArray) + '&nodeTimeReady=' + JSON.stringify(newTimeArray) + '&routeDirection=' + newDirection + '&routeTitle=' + newTitle,
                success: function (data) {
                    alert(data);
                },
                error: function () {
                    alert('Ошибка. Данные не отправлены.');
                }
            })

        });

        $('#delete-last').on('click', function () {//now it deletes all cards

            initLocalStorage('node');

            $('.node-card-item').remove();

            adminMap.removeLayer(marker);

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
        
        //date and time functions

        function toDate(dStr) {
            var now = new Date();
            now.setHours(dStr.substr(0, dStr.indexOf(":")));
            now.setMinutes(dStr.substr(dStr.indexOf(":") + 1));
            now.setSeconds(0);
            return now;
        }

        function toMinutes(milliseconds) {
            return milliseconds / 1000 / 60;
        }
        //========================

        var control;
        var trigger = 0;
        var loc = [];
        var marker = [];
        var location_old = [];
        var marker_old = [];

        function draw(nodeNameArr, loc, nodeLatArr, nodeLngArr, adminPage) {
            if (!adminPage) {
                trigger = 1;

                control = L.Routing.control({
                    waypoints: [
                        loc[0],
                        loc[1]
                    ],
                    routeWhileDragging: false,
                    lineOptions: {
                        addWaypoints: false
                    }
                }).addTo(map);

                for (var q = 2; q < loc.length; q++) {
                    control.spliceWaypoints(control.getWaypoints().length, 0, loc[q]);
                }

                for (var i = 0; i < nodeNameArr.length; i++) {
                    marker[i] = new L.marker([nodeLatArr[i], nodeLngArr[i]]).bindPopup(nodeNameArr[i]).addTo(map);
                }
            } else {
                trigger = 1;

                control = L.Routing.control({
                    waypoints: [
                        loc[0],
                        loc[1]
                    ],
                    routeWhileDragging: false,
                    lineOptions: {
                        addWaypoints: false
                    }
                }).addTo(adminMap);

                for (var q = 2; q < loc.length; q++) {
                    control.spliceWaypoints(control.getWaypoints().length, 0, loc[q]);
                }

                for (var i = 0; i < nodeNameArr.length; i++) {
                    marker[i] = new L.Marker([nodeLatArr[i], nodeLngArr[i]]).bindPopup(nodeNameArr[i]).addTo(adminMap);
                }
            }
        }

        function start(nodeNameArr, nodeLatArr, nodeLngArr, adminPage) {
            if (!adminPage) {
                if (trigger == 1) {
                    location_old = loc;
                    marker_old = marker;

                    marker = [];
                    loc = [];

                    control.spliceWaypoints(0, location_old.length);
                    marker_old.forEach(function (item, i, marker_old) {
                        map.removeLayer(item);
                    });
                    trigger = 0;
                }

                for (var i = 0; i < nodeNameArr.length; i++) {
                    loc[i] = L.latLng(nodeLatArr[i], nodeLngArr[i]);
                }

                if (loc[0] != 0 && loc[1] != 0) {
                    draw(nodeNameArr, loc, nodeLatArr, nodeLngArr, false);
                }
            } else {
                if (trigger == 1) {
                    location_old = loc;
                    marker_old = marker;

                    marker = [];
                    loc = [];

                    control.spliceWaypoints(0, location_old.length);
                    marker_old.forEach(function (item, i, marker_old) {
                        adminMap.removeLayer(item);
                    });
                    trigger = 0;
                }

                for (var i = 0; i < nodeNameArr.length; i++) {
                    loc[i] = L.latLng(nodeLatArr[i], nodeLngArr[i]);
                }

                if (loc[0] != 0 && loc[1] != 0) {
                    draw(nodeNameArr, loc, nodeLatArr, nodeLngArr, true);
                }
            }

        }
        //========================
    </script>
</div>
</div>
