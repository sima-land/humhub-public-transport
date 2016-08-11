<?php

use yii\helpers\Html;
\humhub\modules\transport\MapAsset::register($this);

/* @var $this yii\web\View */
/* @var $model humhub\modules\transport\models\PtmNode */

$this->title = 'Добавить остановку';
$this->params['breadcrumbs'][] = ['label' => 'Остановки', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('../layouts/breadcrumbs.php')?>
<div class="container">
<div class="ptm-node-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
    <div id="map"></div>
</div>
</div>