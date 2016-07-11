<?php
humhub\modules\public_transport_map\Assets::register($this);

use yii\helpers\Html;
use yii\widgets\ActiveForm;
/** @var class $model */
?>


<div class="admin-panel">
    <?php
        $form = ActiveForm::begin([
            'id'=>'login-form',
            'options' => ['class' => 'form-horizontal'],
        ]);

        $form->field($model, 'login')->textInput();
        $form->field($model, 'password')->passwordInput();
    ?>
    <div class="form-group">
        <div class="col-lg-offset-1 col-lg-11">
            <?= Html::submitButton('Вход', ['class' => 'btn btn-primary']) ?>
    </div>
    </div>
    <?php
        ActiveForm::end();
    ?>
<!--
    <form action="adminPanel.php" method="post">
        <input name="login" type="text" placeholder="Login" required />
        <input name="password" type="text" placeholder="Password" required />
        <input id="login-button" type="submit" value="Войти" />
    </form>
-->
</div>
