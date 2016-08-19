<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use humhub\modules\transport\models\PtmDirection;
use humhub\modules\transport\models\PtmNode;

/* @var $this yii\web\View */
/* @var $model humhub\modules\transport\models\PtmRoute */
/* @var $form yii\widgets\ActiveForm */

$nodes = PtmNode::getAll();
?>

<div class="ptm-route-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'direction_id')->dropDownList(PtmDirection::getAll()) ?>
            <?php for($i = 0; $i < count($nodes)-1; $i++):?>
                <?= $form->field($model, "nodesArr[$i]")->dropDownList($nodes, ['style' => 'width:48%; float:left;margin-bottom:5px;margin-right:25px'])->label(false) ?>

                <div class='input-group date' id="timepicker-<?=$i?>">
                    <?= $form->field($model, "nodesTimeArr[$i]")->textInput(['style' => 'width:48%; float:left;margin-bottom:5px;margin-top: -10px;'])->label(false) ?>
                    <span class="input-group-addon" style="float: left;margin-top: -11px;">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
                <?php endfor?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Изменить', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<script type="text/javascript">
    $(function () {
        $('[id^="timepicker-"]').datetimepicker({
            format: 'HH:mm'
        });
    });
</script>