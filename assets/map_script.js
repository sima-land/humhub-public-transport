/**
 * Map initialization.
 *
 * Initializes map using MapBox API.
 */
var map = L.map('map');

L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoiYXNhbmgiLCJhIjoiY2lweHZzN2E1MDA3cmh4bm83a3BqeTFhYSJ9._Nf0tZAU-7JSwX8zcUnELA', {
    attribution: "<a href='index.php?r=public_transport_map%2Fdefault%2Fadmin-panel'>Go to admin panel</a>",
    maxZoom: 18,
    minZoom: 4,
    id: 'asanh.0god5b4e',
    accessToken: 'pk.eyJ1IjoiYXNhbmgiLCJhIjoiY2lweHZzN2E1MDA3cmh4bm83a3BqeTFhYSJ9._Nf0tZAU-7JSwX8zcUnELA'
}).addTo(map);

/**
 * Variables initialization.
 */

var control;
var trigger = 0;
var loc = [];
var marker = [];
var location_old = [];
var marker_old = [];

/**
 * Functions of drawing routes and collecting data.
 *
 * The first one draws routes, the second one clears the map, then collects coordinates and passes it to the first one.
 * WARNING! Changing variable name 'loc' breaks everything (page refreshing constantly).
 */

var draw = function (nodeNameArr, loc, nodeLatArr, nodeLngArr) {
    trigger = 1;

    control = L.Routing.control({
        waypoints: [
            loc[0],
            loc[1]
        ],
        routeWhileDragging: false,
        lineOptions : {
            addWaypoints: false
        }
    }).addTo(map);

    for (var q = 2; q < loc.length; q++) {
        //alert('splice waypoint');
        control.spliceWaypoints(control.getWaypoints().length, 0, loc[q]);
    }

    for (var i = 0; i < nodeNameArr.length; i++) {
        marker[i] = new L.marker([nodeLatArr[i],nodeLngArr[i]]).bindPopup(nodeNameArr[i]).addTo(map);
    }
}

var start = function(nodeNameArr, nodeLatArr, nodeLngArr) {
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
        draw(nodeNameArr, loc, nodeLatArr, nodeLngArr);
    }
}

function mapZoom(id, nodeLat, nodeLng) {
    map.setView([nodeLat,nodeLng], 15);
    marker[id].openPopup();
    return;
}

