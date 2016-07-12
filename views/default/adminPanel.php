<?php
humhub\modules\public_transport_map\Assets::register($this);

use yii\helpers\Html;
use yii\widgets\ActiveForm;
/** @var class $model */
?>


<div class="admin-panel" style="border-style: none;">
    <div class="form-group">
        <div class="col-lg-6">
        <?php
        
        $form = ActiveForm::begin([
            'id'=>'login-form',
            'options' => ['class' => 'form-horizontal'],
        ]);

        ?>
        <?=$form->field($model, 'login')->textInput();?>
        <?=$form->field($model, 'password')->passwordInput();?>

            <?= Html::submitButton('Вход', ['class' => 'btn btn-primary']) ?>


        <div style="color: indianred; margin-top: 20px;"><?=$error_message?></div>


        <?php
            ActiveForm::end();
        ?>
        </div>
    </div>
</div>
