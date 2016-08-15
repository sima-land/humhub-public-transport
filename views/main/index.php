<?php

use yii\widgets\ActiveForm;

?>
<?= $this->render('/layouts/main', ['is_admin' => $is_admin]) ?>

<div class="container">
    <div class="row">
        <h1>Расписание автобусов</h1>
        <hr>
        <div role="tabpanel" class="tab-pane active" id="today">
            <div class="form-group col-lg-6">
                <label for="sel1">Направление:</label>
                <select class="form-control" id="direction">
                    <?php foreach ($directions as $key => $direction): ?>
                        <option data-direction="<?= $key ?>"><?= $direction ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group col-lg-6">
                <label for="sel1">Маршрут:</label>
                <select class="form-control" id="route">
                </select>
            </div>
        </div>
        <div role="tabpanel" class="tab-pane active" id="tomorrow">
        </div>
    </div>
    <div class="ptm-schedule-index">
        <table class="table table-striped table-bordered">
            <thead>
            <th>Остановка</th>
            <th>Время</th>
            </thead>
            <tbody id="t-body">
            </tbody>
        </table>
    </div>
    <div id="map"></div>

</div>
