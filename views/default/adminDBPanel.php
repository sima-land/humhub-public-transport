<?php
humhub\modules\public_transport_map\Assets::register($this);

?>
<div class="row">
    <div class="col-lg-3">
        <div class="row">
            <div class="table-table">
                <?php
                echo "<div class='table-table'>";
                echo "<div class='table-head'><label class='control-label' style='padding-top: 7px; margin-bottom: 10px; background-color: none;'>Расписание</label></div>";
                echo "<div class='table-row'><div class='table-item'>id</div><div class='table-item'>start_at</div><div class='table-item'>route_id</div><div class='table-item'>comment</div></div>";
                foreach ($schedule as $item) {
                    echo "<div class='table-row'>";
                    echo "<div class='table-item'>$item->id</div>";
                    echo "<div class='table-item'>$item->start_at</div>";
                    echo "<div class='table-item'>$item->route_id</div>";
                    echo "<div class='table-item'>$item->comment</div>";
                    echo "</div>";
                }
                echo "</div>";
                ?>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="row">
            <div class="table-table">
                <?php
                echo "<div class='table-table'>";
                echo "<div class='table-head'><label class='control-label' style='padding-top: 7px; margin-bottom: 10px; background-color: none;'>Остановки</label></div>";
                echo "<div class='table-row'><div class='table-item'>id</div><div class='table-item'>name</div><div class='table-item'>lat</div><div class='table-item'>lng</div></div>";
                foreach ($nodes as $item) {
                    echo "<div class='table-row'>";
                    echo "<div class='table-item'>$item->id</div>";
                    echo "<div class='table-item'>$item->name</div>";
                    echo "<div class='table-item'>$item->lat</div>";
                    echo "<div class='table-item'>$item->lng</div>";
                    echo "</div>";
                }
                echo "</div>";
                ?>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="row">
            <div class="table-table">
                <?php
                echo "<div class='table-table'>";
                echo "<div class='table-head'><label class='control-label' style='padding-top: 7px; margin-bottom: 10px; background-color: none;'>Машруты</label></div>";
                echo "<div class='table-row'><div class='table-item'>id</div><div class='table-item'>direction_id</div><div class='table-item'>title</div></div>";
                foreach ($routes as $item) {
                    echo "<div class='table-row'>";
                    echo "<div class='table-item'>$item->id</div>";
                    echo "<div class='table-item'>$item->direction_id</div>";
                    echo "<div class='table-item'>$item->title</div>";
                    echo "</div>";
                }
                echo "</div>";
                ?>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="row">
            <div class="table-table">
                <?php
                echo "<div class='table-table'>";
                echo "<div class='table-head'><label class='control-label' style='padding-top: 7px; margin-bottom: 10px; background-color: none;'>Остановки в маршрутах</label></div>";
                echo "<div class='table-row'><div class='table-item'>route_id</div><div class='table-item'>node_id</div><div class='table-item'>node_interval</div></div>";
                foreach ($routeNodes as $item) {
                    echo "<div class='table-row'>";
                    echo "<div class='table-item'>$item->route_id</div>";
                    echo "<div class='table-item'>$item->node_id</div>";
                    echo "<div class='table-item'>$item->node_interval</div>";
                    echo "</div>";
                }
                echo "</div>";
                ?>
            </div>
        </div>
    </div>
</div>

<script>

    $(document).ready(function () {
        alert('Внимание! Вы не сможете отменить действия, сделанные на этой странице.');
    });

    $('body').click(function (event) {
        console.log(event.target);
    })
</script>
