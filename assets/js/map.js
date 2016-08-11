$(document).ready(function () {
    "use strict";

    var map = L.map('map').setView([56.838, 60.605], 12);
    var popup = L.popup();
    var marker, mapRoute;

    L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoiYXNhbmgiLCJhIjoiY2lweHZzN2E1MDA3cmh4bm83a3BqeTFhYSJ9._Nf0tZAU-7JSwX8zcUnELA', {
        attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="http://mapbox.com">Mapbox</a>',
        maxZoom: 18,
        id: 'asanh.0god5b4e',
        accessToken: 'pk.eyJ1IjoiYXNhbmgiLCJhIjoiY2lweHZzN2E1MDA3cmh4bm83a3BqeTFhYSJ9._Nf0tZAU-7JSwX8zcUnELA'
    }).addTo(map);
    drawRoute();
    map.on('click', onMapClick);

    function onMapClick(e) {
        clearMap();
        var coordinates = e.latlng;
        $('#ptmnode-lat').val(coordinates.lat);
        $('#ptmnode-lng').val(coordinates.lng);
        L.marker([coordinates.lat, coordinates.lng]).addTo(map);
    }

    function drawRoute() {
        clearMap();
        if (app.jsonNodeList) {
            if (app.jsonNodeList.length > 1) {
                mapRoute = L.polyline([], {color: 'blue'}).addTo(map);
                app.jsonNodeList.forEach(function (routePoint) {
                    mapRoute.addLatLng(L.latLng(
                        parseFloat(routePoint.lat),
                        parseFloat(routePoint.lng)
                    ));
                });
            } else {
                app.jsonNodeList.forEach(function (item) {
                    marker = L.marker([item.lat, item.lng]).addTo(map);
                    marker.bindPopup(item.name).openPopup();
                });
            }
        }
    }

    function clearMap() {
        if (marker) {
            map.removeLayer(marker);
        }
        if (mapRoute) {
            map.removeLayer(mapRoute);
        }
    }


    var direction = $('#direction');
    var route = $('#route');
    if (direction.val()) {
        fillRoutes();
    }
    direction.change(function () {
        fillRoutes();
    });

    function fillRoutes() {
        app.jsonDataList.forEach(function (item, i) {
            if (item.direction == direction.val()) {
                route.find('option').remove();
                var opt = document.createElement('option');
                opt.innerHTML = item.route_name;
                opt.value = "route_" + item.id;
                route.append(opt);
                app.jsonNodeList = item.nodes;
                drawRoute();
            }
        });
    }
});
