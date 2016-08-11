<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model humhub\modules\transport\models\PtmDirection */

$this->title = 'Изменить направление: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Направления', 'url' => ['index']];
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
