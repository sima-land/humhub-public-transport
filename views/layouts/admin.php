<?php

use \yii\helpers\Url;
?>
<div class="container">
    <div class="row">
        <ul class="nav nav-tabs">
            <li class=""><a href="<?= Url::to(['/transport/main/index']) ?>">Запись на автобус</a>
            </li>
            <li class="main"><a href="<?= Url::to(['/transport/admin/index']) ?>">Администрирование</a>
            </li>
        </ul>
    </div>
</div>