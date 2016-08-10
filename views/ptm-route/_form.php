<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use humhub\modules\transport\models\PtmDirection;
use humhub\modules\transport\models\PtmNode;

/* @var $this yii\web\View */
/* @var $model humhub\modules\transport\models\PtmRoute */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ptm-route-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'direction_id')->dropDownList(PtmDirection::getAll()) ?>

    <?= $form->field($model, 'nodesArr')->checkboxList(PtmNode::getAll(), ['multiple' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Изменить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
