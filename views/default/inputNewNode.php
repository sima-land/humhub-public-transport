<?php
humhub\modules\public_transport_map\Assets::register($this);

use yii\helpers\Html;
use yii\widgets\ActiveForm;


?>
<div>
    <?php
    $formNode = ActiveForm::begin([
        'id' => 'add-node-form'
    ]);
    ?>


    <?= Html::submitButton('Добавить остановку', ['class' => 'btn btn-primary']) ?>

    <?php
    ActiveForm::end();
    ?>
</div>
