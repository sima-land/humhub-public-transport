<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model humhub\modules\transport\models\PtmSchedule */
$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Расписание', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('../layouts/breadcrumbs.php') ?>
<div class="container">
    <div class="ptm-schedule-view">

        <h1><?= Html::encode($this->title) ?></h1>

        <p>
            <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data'  => [
                    'confirm' => 'Вы уверены, что хотите удалить этот элемент?',
                    'method'  => 'post',
                ],
            ]) ?>
        </p>

        <?= DetailView::widget([
            'model'      => $model,
            'attributes' => [
                'departure_at:dateTime',
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
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{update} {delete}',
                    'urlCreator' => function($action, $model, $key, $index) {
                        $action = $action == 'delete' ? 'delete-node' : $action;
                        return \yii\helpers\Url::to(['ptm-route/' . $action, 'id' => $model->id]);
                    },
                ],
            ],
        ]); ?>
        <?= Html::a('Добавить остановку',['ptm-node/create?cookie=' . $model->id] , ['class' => 'btn btn-success']) ?>


    </div>
</div>
