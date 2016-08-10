<?php

?>
<div class="container">
    <div class="row">
        <ul class="nav nav-pills">
            <li class="noround active"><a href="#home">Запись на автобус</a></li>
            <?php if ($is_admin): ?>
                <li class="noround"><a
                        href="<?= \yii\helpers\Url::to(['/transport/admin/index']) ?>">Администрирование</a></li>
            <?php endif; ?>
        </ul>
    </div>
</div>