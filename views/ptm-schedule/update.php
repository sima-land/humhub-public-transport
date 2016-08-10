<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model humhub\modules\transport\models\PtmSchedule */

$this->title = 'Изменить расписание по маршруту: ' . $model->route->name;
$this->params['breadcrumbs'][] = ['label' => 'Расписание', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->route->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('../layouts/breadcrumbs.php') ?>
<div class="container">
<div class="ptm-schedule-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
</div>