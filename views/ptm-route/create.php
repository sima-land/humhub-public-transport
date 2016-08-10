<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model humhub\modules\transport\models\PtmRoute */

$this->title = 'Create Ptm Route';
$this->params['breadcrumbs'][] = ['label' => 'Ptm Routes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ptm-route-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
