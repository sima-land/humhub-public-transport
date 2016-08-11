<?php

use yii\widgets\ActiveForm;

\humhub\modules\transport\Assets::register($this);
?>
<?= $this->render('/layouts/main', ['is_admin' => $is_admin]) ?>

<div class="container">
    <div class="row">
        <h2>Расписание автобусов</h2>
        <ul class="nav nav-tabs" role="tablist" style="margin-bottom: 40px;">
            <li role="presentation" class="active">
                <a href="#today" aria-controls="home" role="tab" data-toggle="tab"><?= date('d M') ?></a>
            </li>
            <li role="presentation">
                <a href="#tomorrow" aria-controls="profile" role="tab" data-toggle="tab"><?= date('d M',
                        strtotime('+1 day')) ?></a>
            </li>
        </ul>
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="today">
                <div class="form-group">
                    <label for="sel1">Направление:</label>
                    <select class="form-control" id="direction">
                        <?php foreach ($directions as $key => $direction):?>
                            <option data-direction="<?= $key?>"><?= $direction?></option>
                        <?php endforeach;?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="sel1">Маршрут:</label>
                    <select class="form-control" id="route">
                    </select>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane active" id="tomorrow">
            </div>
        </div>
        <div id="map"></div>
    </div>
</div>
