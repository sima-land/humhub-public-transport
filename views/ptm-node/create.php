<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model humhub\modules\transport\models\PtmNode */

$this->title = 'Create Ptm Node';
$this->params['breadcrumbs'][] = ['label' => 'Ptm Nodes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('../layouts/breadcrumbs.php')?>
<div class="container">
<div class="ptm-node-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
</div>