<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel humhub\modules\transport\models\PtmScheduleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Расписание';
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('../layouts/breadcrumbs.php')?>
<div class="container">
    <div class="ptm-schedule-index">

        <h1><?= Html::encode($this->title) ?></h1>

        <p>
            <?= Html::a('Создать', ['create'], ['class' => 'btn btn-primary']) ?>
        </p>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel'  => $searchModel,
            'columns'      => [
                ['class' => 'yii\grid\SerialColumn'],
                'departure_at',
                'route.name',
                'comment:ntext',
                [
                    'class' => 'yii\grid\ActionColumn',
                ],
            ],
        ]); ?>
    </div>
</div>