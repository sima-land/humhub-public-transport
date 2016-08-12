<?php

use yii\helpers\Url;

?>
<?= $this->render('/layouts/admin') ?>

<div class="container">
    <ul class="nav nav-pills nav-justified top">
        <li role="presentation" class="colored"><a
                href="<?= Url::to(['/transport/ptm-schedule/index']) ?>">Расписание</a></li>
        <li role="presentation" class="colored"><a href="<?= Url::to(['/transport/ptm-route/index']) ?>">Маршруты</a>
        </li>
        <li role="presentation" class="colored"><a href="<?= Url::to(['/transport/ptm-node/index']) ?>">Остановки</a>
        </li>
        <li role="presentation" class="colored"><a
                href="<?= Url::to(['/transport/ptm-direction/index']) ?>">Направления</a></li>
    </ul>
    <div class="site-index">
        <div class="jumbotron">
            <h2 class="text-center">Административный раздел</h2>
        </div>
    </div>
</div>
