$(document).ready(function () {
    "use strict";

    var map = L.map('map').setView([56.838, 60.605], 12);
    var popup = L.popup();

    L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoiYXNhbmgiLCJhIjoiY2lweHZzN2E1MDA3cmh4bm83a3BqeTFhYSJ9._Nf0tZAU-7JSwX8zcUnELA', {
        attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="http://mapbox.com">Mapbox</a>',
        maxZoom: 18,
        id: 'asanh.0god5b4e',
        accessToken: 'pk.eyJ1IjoiYXNhbmgiLCJhIjoiY2lweHZzN2E1MDA3cmh4bm83a3BqeTFhYSJ9._Nf0tZAU-7JSwX8zcUnELA'
    }).addTo(map);

    if (app.jsonNodeList) {
        if (app.jsonNodeList.length > 1) {
            var mapRoute = L.polyline([], {color: 'blue'}).addTo(map);
            app.jsonNodeList.forEach(function (routePoint) {
                mapRoute.addLatLng(L.latLng(
                    parseFloat(routePoint.lat),
                    parseFloat(routePoint.lng)
                ));
            });
        } else {
            app.jsonNodeList.forEach(function (item) {
                var marker = L.marker([item.lat, item.lng]).addTo(map);
                marker.bindPopup(item.name).openPopup();
            });
        }
    }
    map.on('click', onMapClick);

    function onMapClick (e) {
        var coordinates = e.latlng;
        $('#ptmnode-lat').val(coordinates.lat);
        $('#ptmnode-lng').val(coordinates.lng);
        popup
            .setLatLng(e.latlng)
            .setContent("Новая остановка")
            .openOn(map);
    }
});
