<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use humhub\modules\transport\models\PtmRoute;

/* @var $this yii\web\View */
/* @var $model humhub\modules\transport\models\PtmSchedule */
/* @var $form yii\widgets\ActiveForm */
?>
<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css"/>

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script
    src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>

<div class="ptm-schedule-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class='input-group date' id='datetimepicker1'>
        <?= $form->field($model, 'departure_at')->textInput(['class' => 'form-control', 'value' => date('d.m H:i', strtotime($model->departure_at))]) ?>
        <span class="input-group-addon" style="padding-top: 26px;">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
    </div>
    <?= $form->field($model, 'route_id')->dropDownList(PtmRoute::getAll()) ?>

    <?= $form->field($model, 'comment')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Изменить',
            ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script type="text/javascript">
    $(function () {
        $('#datetimepicker1').datetimepicker({
            format: 'DD.MM HH:mm'
        });
    });
</script>