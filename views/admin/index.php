<?php

use yii\helpers\Url;
?>
<?= $this->render('/layouts/admin') ?>

<div class="container">
    <ul class="nav nav-pills nav-justified">
        <li role="presentation"><a href="<?= Url::to(['/transport/ptm-direction/index'])?>">Направления</a></li>
        <li role="presentation" class="active"><a href="<?= Url::to(['/transport/ptm-schedule/index'])?>">Расписание</a></li>
        <li role="presentation"><a href="<?= Url::to(['/transport/ptm-route/index'])?>">Маршрут</a></li>
        <li role="presentation"><a href="<?= Url::to(['/transport/ptm-node/index'])?>">Остановка</a></li>
    </ul>
    <div class="site-index">
        <div class="jumbotron">
            <h1>Административный раздел</h1>
        </div>
    </div>
</div>
