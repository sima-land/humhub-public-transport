<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel humhub\modules\transport\models\PtmNodeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Остановки';
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('../layouts/breadcrumbs.php')?>
<div class="container">
<div class="ptm-node-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить остановку', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {delete}'

            ],
        ],
    ]); ?>
</div>
</div>
