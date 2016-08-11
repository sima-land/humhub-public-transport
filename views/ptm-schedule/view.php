<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model humhub\modules\transport\models\PtmSchedule */
$this->title = $model->route->name;
$this->params['breadcrumbs'][] = ['label' => 'Расписание', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('../layouts/breadcrumbs.php') ?>
<div class="container">
    <div class="ptm-schedule-view">

        <h1><?= Html::encode($this->title) ?></h1>

        <?= DetailView::widget([
            'model'=> $model,
            'attributes' => [
                'departure_at',
                'route.name',
                'comment:ntext',
            ],
        ]) ?>

        <?= \yii\grid\GridView::widget([
            'dataProvider' => $nodesDataProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'name',
                'lat',
                'lng',
            ],
        ]); ?>
    </div>
</div>
