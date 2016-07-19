<?php
humhub\modules\public_transport_map\Assets::register($this);
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<!--i think it will be better to make popups with messages instead of alert()-->
<div class="b-popup" id="popup1">
    <div class="b-popup-content" id="popup-content">

    </div>
</div>

<div class="row">
    <div class="col-lg-2"></div>
    <div class="col-lg-8" id="caution"><h2>Внимание! Вы не сможете отменить действия, совершенные на этой странице.</h2></div>
</div>


<div class="row">
    <div class="col-lg-1"></div>
    <div class="col-lg-5">
        <div class="row">
            <div class="table-table">
                <?php
                echo "<div class='table-table' id='schedule'>";
                echo "<div class='table-head'><label class='control-label' style='padding-top: 7px; margin-bottom: 10px; background-color: transparent;'>Расписание</label></div>";
                echo "<div class='table-row'><div class='table-item'></div><div class='table-item'>id</div><div class='table-item'>start_at</div><div class='table-item'>route_id</div><div class='table-item'>comment</div></div>";
                $counter = 0;
                foreach ($schedule as $item) {
                    echo "<div class='table-row'>";
                    echo "<div id='$counter' class='table-item table-delete-row' table-type='schedule'>X</div>";
                    echo "<div class='table-item' id='id'>$item->id</div>";
                    echo "<div class='table-item'>$item->start_at</div>";
                    echo "<div class='table-item'>$item->route_id</div>";
                    echo "<div class='table-item'>$item->comment</div>";
                    echo "</div>";
                    $counter++;
                }
                    echo "<div class='table-row'>";
                        echo "<div class='table-item' id='add-item'>Add</div>";
                        echo "<div class='table-item'>auto</div>";
                        echo "<div class='table-item' style='padding: 0px;'><input type='text' id='date' required></div>";
                        echo "<div class='table-item'><input type='text' id='route' required></div>";
                        echo "<div class='table-item'><input type='text' id='comment' required></div>";
                    echo "</div>";
                echo "</div>";
                ?>
            </div>
        </div>
    </div>

    <div class="col-lg-5">
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
</div>


<div class="row">
    <div class="col-lg-2"></div>
    <div class="col-lg-8">
        <div id="delete-all">Очистить</div>
        <div id="delete-rows" table-type="schedule"></div>
    </div>
</div>


<div class="row">
    <div class="col-lg-2"></div>
    <div class="col-lg-8">

        <div class="btn btn-primary" id="delete-request">Удалить выбранные строки</div>

    </div>
</div>


<script>

    var itemsToDelete = [];

    $(document).ready(function () {
        PopUpHide();
        $('#date').mask("9999-99-99 99:99" , { placeholder: "yyyy-mm-dd hh:mm" });
    });

    $('#add-item').on('click', function () {

        var date = $('input#date').val();
        var route = $('input#route').val();
        var comment = $('input#comment').val();

        if (parseInt(date.substr(0, 4)) < 2016 || parseInt(date.substr(5, 2)) > 12 || parseInt(date.substr(8, 2)) > 31
            || parseInt(date.substr(11, 2)) > 23 || parseInt(date.substr(14,2)) > 59 || date.length < 16) {
            PopUpShow('Please input correct date');
            return;
        }

        if (route.length < 1) {
            PopUpShow('Fill route id');
            return;
        }

        date = date + ':00';//it is necessary to add seconds for correct format (format of DB)

        $.ajax({
            type: 'GET',
            url: 'index.php?r=public_transport_map%2Fdefault%2Fadd-schedule&date=' + JSON.stringify(date) + '&route=' + JSON.stringify(route) + '&comment=' + JSON.stringify(comment),
            success: function (data) {
                if (data = 1) {
                    PopUpShow('success');
                    $('#popup1').on('click', function () {
                        location.reload();
                    });
                } else {
                    PopUpShow('something wrong');
                        location.reload();
                }
            },
            error: function () {
                PopUpShow('Request was not sent');
            }
        });

    });

    $('.table-row-info').on('click', function () {
        PopUpShow('С этой таблицей связана другая таблица. Удаляйте из нее.');
    });

    $('body').click( function (event) {

        if ($(event.target).attr('id') == 'delete-all') {
            itemsToDelete = [];
            console.log(itemsToDelete);
            drawTabs();
            return 0;
        }

        if ($(event.target).attr('id') == 'popup1') {
            $('.b-popup-content').on('click', function () {});
            PopUpHide();
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
                    PopUpShow('unable table');
                }
            }

            console.log(schedule);

            $.ajax({
                type: 'GET',
                url: 'index.php?r=public_transport_map%2Fdefault%2Fdelete-rows&scheduleIDs=' + JSON.stringify(schedule) + '&routesIDs=' + JSON.stringify(routes),//table id
                success: function(data) {
                    PopUpShow('Удалено');
                    console.log('Controller returned:' + data);
                    location.reload();
                },
                error: function(data) {
                    PopUpShow('Произошла ошибка при отправке запроса');
                    console.log(data);
                }
            });

        }

        /**
         * array of items which wer selected to delete.
         * we need it for showing tabs at the bottom of page
         */

        var deleteItem = new Object();

        deleteItem.table = $(event.target).attr('table-type');
        deleteItem.row = $(event.target).attr('id');
        deleteItem.id = $(event.target).next().text();

        if (typeof deleteItem.table == 'undefined') deleteItem.table = null;

        if (!existsInArray(deleteItem, itemsToDelete) && !(deleteItem.table === null) && ((deleteItem.table == 'routes') || (deleteItem.table == 'schedule'))) itemsToDelete.push(deleteItem);

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
    function PopUpShow(content = null){

        document.getElementById('popup-content').innerHTML = '';

        $(".b-popup-content").append(content);
        $("#popup1").show();

    }
    function PopUpHide(){
        $("#popup1").hide();
    }

</script>
