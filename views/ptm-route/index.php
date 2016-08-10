<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel humhub\modules\transport\models\PtmRouteSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ptm Routes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ptm-route-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Ptm Route', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'direction_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
