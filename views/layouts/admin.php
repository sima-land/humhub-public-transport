<?php

use \yii\helpers\Url;

\humhub\modules\transport\Assets::register($this);

?>
<div class="container">
    <div class="row">
        <ul class="nav nav-pills">
            <li class="noround"><a href="<?= Url::to(['/transport/main/index']) ?>">Запись на автобус</a>
            </li>
            <li class="noround active"><a href="<?= Url::to(['/transport/admin/index']) ?>">Администрирование</a>
            </li>
        </ul>
    </div>
</div>