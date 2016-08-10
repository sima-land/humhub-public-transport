<?php

namespace humhub\modules\transport;

use yii\web\AssetBundle;

class Assets extends AssetBundle
{
    public $css = [
     //   'less/styles.css'
    ];
    public $js = [
    ];
    public function init()
    {
        $this->sourcePath = dirname(__FILE__) . '/assets';
        parent::init();
    }

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
?>
