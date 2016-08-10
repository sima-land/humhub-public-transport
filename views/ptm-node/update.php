<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model humhub\modules\transport\models\PtmNode */

$this->title = 'Update Ptm Node: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Ptm Nodes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ptm-node-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
