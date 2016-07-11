<?php
humhub\modules\public_transport_map\Assets::register($this);
use yii\helpers\Html;
?>
<link rel="stylesheet" href="http://cdn.leafletjs.com/leaflet/v0.7.7/leaflet.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/i18n/jquery-ui-i18n.js"></script>
<script src="http://cdn.leafletjs.com/leaflet/v0.7.7/leaflet.js"></script>
<div class="admin-panel">
    <h2>Добро пожаловать, <?=$admin[0]->name?>!</h2>
    <?php


    //echo $this->render('mapCreate');

    /*var_dump(Html::encode($model->login));
    echo "<pre>";
    var_dump($admin);
    echo "</pre>";
*/
    ?>
    <div id="mapid" class="map"></div>
<script>
    $(document).ready( function(){
        var mymap = L.map('mapid').setView([51.505, -0.09], 1);
        alert('k');

        L.titleLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoibmVraXRoY2tleTc1IiwiYSI6ImNpcWkwcWFnbjAwOXlod2t4NDB5MWU2ZG0ifQ.Szl2MHg2zsvy28V0Mw_bKA', {
            id: 'nekithckey75.0kmpj69e',
            accessToken: 'pk.eyJ1IjoibmVraXRoY2tleTc1IiwiYSI6ImNpcWkwcWFnbjAwOXlod2t4NDB5MWU2ZG0ifQ.Szl2MHg2zsvy28V0Mw_bKA'
        }).addto(mymap);
        var marker = L.marker([51.5, -0.09]).addTo(mymap);

    });

    mymap.on('click', function(e) {
        alert(e.latlng + 't'); // e is an event object (MouseEvent in this case)
    });

</script>
</div>
