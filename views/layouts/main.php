<div class="container">
    <div class="row">
        <ul class="nav nav-tabs">
            <li class="main"><a href="#home">Расписание автобусов</a></li>
            <?php if ($is_admin): ?>
                <li class=""><a
                        href="<?= \yii\helpers\Url::to(['/transport/admin/index']) ?>">Администрирование</a></li>
            <?php endif; ?>
        </ul>
    </div>
</div>