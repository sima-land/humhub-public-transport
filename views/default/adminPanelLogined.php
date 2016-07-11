<?php
humhub\modules\public_transport_map\Assets::register($this);
use yii\helpers\Html;
?>

<div class="admin-panel">
    <h2>Добро пожаловать, <?=$admin[0]->name?>!</h2>
    <?php


    echo $this->render('mapCreate');
    /*var_dump(Html::encode($model->login));
    echo "<pre>";
    var_dump($admin);
    echo "</pre>";
*/
    ?>
</div>
