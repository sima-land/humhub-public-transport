<?php

use yii\helpers\Html;
use yii\helpers\Url;
use \yii\widgets\ActiveForm;

?>
<div class="container panel">
    <div class="panel-heading">Настройка модуля</div>
    <hr>
    <div class="panel-body">
        <p>Скрытие/Показ иконки расписания в верхнем меню</p>
        <br/>
        <?php $form = ActiveForm::begin(); ?>
        <div class="form-group">
            <?php echo $form->field($model, 'is_shown')->checkbox([$model->is_shown ? 'checked' : '']); ?>
        </div>

        <hr>
        <?php echo Html::submitButton('Сохранить', array('class' => 'btn btn-primary')); ?>
        <a class="btn btn-default"
           href="<?php echo Url::to(['/admin/module']); ?>"><?php echo Yii::t('TransportModule.base',
                'Back to modules'); ?></a>

        <?php ActiveForm::end(); ?>
    </div>
</div>