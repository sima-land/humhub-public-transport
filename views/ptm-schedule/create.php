<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model humhub\modules\transport\models\PtmSchedule */

$this->title = 'Create Ptm Schedule';
$this->params['breadcrumbs'][] = ['label' => 'Ptm Schedules', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ptm-schedule-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
