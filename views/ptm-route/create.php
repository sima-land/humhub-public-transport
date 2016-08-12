<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model humhub\modules\transport\models\PtmRoute */

$this->title = 'Создать маршрут';
$this->params['breadcrumbs'][] = ['label' => 'Маршруты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('../layouts/breadcrumbs.php')?>
<div class="container">
<div class="ptm-schedule-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
</div>