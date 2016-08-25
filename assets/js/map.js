$(document).ready(function () {
    "use strict";

    if (document.getElementById("map")) {
        var map = L.map('map').setView([56.838, 60.605], 12);
        var popup = L.popup();
        var markers = [], mapRoute;

        L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
            attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="http://mapbox.com">Mapbox</a>',
            maxZoom: 18,
            id: 'asanh.0god5b4e',
            accessToken: 'pk.eyJ1IjoiYXNhbmgiLCJhIjoiY2lweHZzN2E1MDA3cmh4bm83a3BqeTFhYSJ9._Nf0tZAU-7JSwX8zcUnELA'
        }).addTo(map);
        drawRoute();
        if (window.location.pathname == '/transport/admin/node/create' || window.location.pathname.indexOf('/transport/admin/node/update') !== -1) {
            map.on('click', onMapClick);
        }
    }

    function onMapClick(e) {
        clearMap();
        var coordinates = e.latlng;
        var marker;
        $('#ptmnode-lat').val(coordinates.lat);
        $('#ptmnode-lng').val(coordinates.lng);
        marker = L.marker([coordinates.lat, coordinates.lng]).addTo(map);
        markers.push(marker);
    }

    function drawRoute() {
        var marker;
        clearMap();
        if (app.jsonNodeList) {
            mapRoute = L.polyline([], {color: 'blue'}).addTo(map);
            var mlt = 0, mlg = 0, count = 0;
            app.jsonNodeList.forEach(function (routePoint) {
                // check if node has coordinates
                if (routePoint.lat && routePoint.lng) {
                    count++;
                    if (app.jsonNodeList.length > 1) {
                        mapRoute.addLatLng(L.latLng(
                            parseFloat(routePoint.lat),
                            parseFloat(routePoint.lng)
                        ));
                    }
                    mlt = mlt + parseFloat(routePoint.lat);
                    mlg = mlg + routePoint.lng;

                    marker = L.marker([routePoint.lat, routePoint.lng]).addTo(map);
                    marker.bindPopup(routePoint.name);
                    markers.push(marker);
                }
            });
            if (mlt && mlg) {
                map.setView([mlt / count, mlg / count], 12);
            }
        }
    }

    function clearMap() {
        if (markers) {
            for (var i = 0; i < markers.length; i++) {
                map.removeLayer(markers[i]);
            }
            markers = [];
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

    route.change(function () {
        app.jsonDataList.forEach(function (item, i) {
            if ((item.direction == direction.val()) && (route.val() == "route_" + item.id)) {
                app.jsonNodeList = item.nodes;
                drawRoute();
                var data = '';
                item.nodes.forEach(function (node, i) {
                    data += '<tr><td>' + node.name + '</td><td>' + node.time + '</td></tr>';
                });
                drawTable(item.nodes);
            }
        });
    });

    function fillRoutes() {
        route.find('option').remove();
        app.jsonDataList.forEach(function (item, i) {
            if ((item.direction == direction.val())) {
                var opt = document.createElement('option');
                var date = item.departure_at.split(' ')[1];
                opt.innerHTML = item.route_name + ': ' + date.substr(0, 5);
                opt.value = "route_" + item.id;
                route.append(opt);
                if (route.val() == "route_" + item.id) {
                    app.jsonNodeList = item.nodes;
                    drawRoute();
                    drawTable(item.nodes);
                }
            }
        });
    }

    function drawTable(nodes) {
        var data = '';
        nodes.forEach(function (node, i) {
            data += '<tr><td>' + node.name + '</td><td>' + node.time + '</td></tr>';
        });
        $('tbody').html(data);
    }
});
