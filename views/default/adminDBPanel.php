<?php
humhub\modules\public_transport_map\Assets::register($this);

?>
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
                    echo "<div id='$counter' class='table-item table-delete-row' table-type='schedule'>X</div>";
                    echo "<div class='table-item'>$item->id</div>";
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
                    echo "<div id='$counter' class='table-item table-delete-row' table-type='nodes'>X</div>";
                    echo "<div class='table-item'>$item->id</div>";
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
                    echo "<div class='table-item'>$item->id</div>";
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
                    echo "<div id='$counter' class='table-item table-delete-row' table-type='routeNodes'>X</div>";
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


<script>

    var itemsToDelete = [];

    $(document).ready(function () {
        //alert('Внимание! \r\rВы не сможете отменить действия, сделанные на этой странице.');
    });

    $('body').click( function (event) {
        var id = $(event.target).attr('id');
        var tableType = $(event.target).attr('table-type');
        console.log(id);
        console.log(tableType);

        var deleteItem = new Object();

        deleteItem.table = tableType;
        deleteItem.row = id;

        itemsToDelete.push(deleteItem);

        /*if (typeof tableType != 'undefined') {
            if (getItemFromLocalStorage(tableType).length != 0) {
                addItemToLocalStorage(id, tableType);
            } else {

                initLocalStorage(tableType);
            }
        }*/
    });


</script>
