<?php
humhub\modules\public_transport_map\Assets::register($this);
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>


<div class="popup"></div>


<div class="row">
    <div class="col-lg-2"></div>
    <div class="col-lg-4">
        <div class="row">
            <div class="table-table">
                <?php
                echo "<div class='table-table' id='schedule'>";
                echo "<div class='table-head'><label class='control-label' style='padding-top: 7px; margin-bottom: 10px; background-color: transparent;'>Расписание</label></div>";
                echo "<div class='table-row'><div class='table-item'></div><div class='table-item'>id</div><div class='table-item'>start_at</div><div class='table-item'>route_id</div><div class='table-item'>comment</div></div>";
                $counter = 0;
                foreach ($schedule as $item) {
                    echo "<div class='table-row'>";
                    echo "<div id='$counter' class='table-item table-row-info' table-type='schedule'>?</div>";
                    echo "<div class='table-item' id='id'>$item->id</div>";
                    echo "<div class='table-item'>$item->start_at</div>";
                    echo "<div class='table-item'>$item->route_id</div>";
                    echo "<div class='table-item'>$item->comment</div>";
                    echo "</div>";
                    $counter++;
                }
                echo "</div>";
                ?>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="row">
            <div class="table-table">
                <?php
                echo "<div class='table-table'>";
                echo "<div class='table-head'><label class='control-label' style='padding-top: 7px; margin-bottom: 10px; background-color: transparent;'>Остановки</label></div>";
                echo "<div class='table-row'><div class='table-item'></div><div class='table-item'>id</div><div class='table-item'>name</div><div class='table-item'>lat</div><div class='table-item'>lng</div></div>";
                $counter = 0;
                foreach ($nodes as $item) {
                    echo "<div class='table-row'>";
                    echo "<div id='$counter' class='table-item table-row-info' table-type='nodes'>?</div>";
                    echo "<div class='table-item' id='id'>$item->id</div>";
                    echo "<div class='table-item'>$item->name</div>";
                    echo "<div class='table-item'>$item->lat</div>";
                    echo "<div class='table-item'>$item->lng</div>";
                    echo "</div>";
                    $counter++;
                }
                echo "</div>";
                ?>
            </div>
        </div>
    </div>
    <div class="col-lg-2"></div>
</div>


<div class="row">
    <div class="col-lg-2"></div>
    <div class="col-lg-4">
        <div class="row">
            <div class="table-table">
                <?php
                echo "<div class='table-table'>";
                echo "<div class='table-head'><label class='control-label' style='padding-top: 7px; margin-bottom: 10px; background-color: transparent;'>Машруты</label></div>";
                echo "<div class='table-row'><div class='table-item'></div><div class='table-item'>id</div><div class='table-item'>direction_id</div><div class='table-item'>title</div></div>";
                $counter = 0;
                foreach ($routes as $item) {
                    echo "<div class='table-row'>";
                    echo "<div id='$counter' class='table-item table-delete-row' table-type='routes'>X</div>";
                    echo "<div class='table-item' id='id'>$item->id</div>";
                    echo "<div class='table-item'>$item->direction_id</div>";
                    echo "<div class='table-item'>$item->title</div>";
                    echo "</div>";
                    $counter++;
                }
                echo "</div>";
                ?>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="row">
            <div class="table-table">
                <?php
                echo "<div class='table-table'>";
                echo "<div class='table-head'><label class='control-label' style='padding-top: 7px; margin-bottom: 10px; background-color: transparent;'>Остановки в маршрутах</label></div>";
                echo "<div class='table-row'><div class='table-item'></div><div class='table-item'>route_id</div><div class='table-item'>node_id</div><div class='table-item'>node_interval</div></div>";
                $counter = 0;
                foreach ($routeNodes as $item) {
                    echo "<div class='table-row'>";
                    echo "<div id='$counter' class='table-item table-row-info' table-type='routeNodes'>?</div>";
                    echo "<div class='table-item'>$item->route_id</div>";
                    echo "<div class='table-item'>$item->node_id</div>";
                    echo "<div class='table-item'>$item->node_interval</div>";
                    echo "</div>";
                    $counter++;
                }
                echo "</div>";
                ?>
            </div>
        </div>
    </div>
    <div class="col-lg-2"></div>
</div>


<div class="row">
    <div class="col-lg-2"></div>
    <div class="col-lg-8">
        <div id="delete-last">Очистить</div>
        <div id="delete-rows" table-type="schedule"></div>
    </div>
    <div class="col-lg-2"></div>
</div>


<div class="row">
    <div class="col-lg-2"></div>
    <div class="col-lg-8">

        <div class="btn btn-primary" id="delete-request">Удалить выбранные строки</div>

    </div>
    <div class="col-lg-2"></div>
</div>


<script>

    var itemsToDelete = [];

    $(document).ready(function () {
        //alert('Внимание! \r\rВы не сможете отменить действия, совершенные на этой странице.');
    });

    $('.table-row-info').on('click', function () {

    });

    $('body').click( function (event) {

        if ($(event.target).attr('id') == 'delete-last') {
            itemsToDelete = [];
            console.log(itemsToDelete);
            drawTabs();
            return 0;
        }

        if ($(event.target).attr('id') == 'delete-request') {

            var schedule = []; var nodes = []; var routeNodes = []; var routes = [];

            for (var i = 0; i < itemsToDelete.length; i++) {
                if (itemsToDelete[i].table == 'schedule') {
                    schedule.push(itemsToDelete[i].id);
                } else if (itemsToDelete[i].table == 'nodes') {
                    nodes.push(itemsToDelete[i].id);
                } else if (itemsToDelete[i].table == 'routeNodes') {
                    routeNodes.push(itemsToDelete[i].row);
                } else if (itemsToDelete[i].table == 'routes') {
                    routes.push(itemsToDelete[i].id);
                } else {
                    alert('unable table');
                }
            }

            console.log(nodes);


            $.ajax({
                type: 'GET',
                url: 'index.php?r=public_transport_map%2Fdefault%2Fdelete-rows&scheduleIDs=' + JSON.stringify(schedule) + '&routesIDs=' + JSON.stringify(routes),//table id
                success: function(data) {
                    alert('Удалено');
                    console.log('Controller returned:' + data);
                },
                error: function(data) {
                    alert('Произошла ошибка при отправке запроса');
                    console.log(data);
                }
            })
        }

        var deleteItem = new Object();

        deleteItem.table = $(event.target).attr('table-type');
        deleteItem.row = $(event.target).attr('id');
        deleteItem.id = $(event.target).next().text();

        if (typeof deleteItem.table == 'undefined') deleteItem.table = null;

        if (!existsInArray(deleteItem, itemsToDelete) && !(deleteItem.table === null) && (deleteItem.table == 'routes')) itemsToDelete.push(deleteItem);

        drawTabs();
        
    });

    function existsInArray(object, array) {
        var i = 0;
        for (i = 0; i < array.length; i++) {
            if ((array[i].row == object.row) && (array[i].table == object.table)) {
                return true;
            }
        }
        return false;
    }

    function drawTabs() {

        var k;

        document.getElementById('delete-rows').innerHTML = '';

        for (k = 0; k < itemsToDelete.length; k++) {
            $('#delete-rows').append("<div id='delete-row-item'>" + 'table = ' + itemsToDelete[k].table + ' : row = ' + itemsToDelete[k].row + "</div>");
        }
    }


</script>
