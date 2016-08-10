<?php

namespace humhub\modules\transport;

use yii\web\AssetBundle;

class Assets extends AssetBundle
{
    public $publishOptions = [
        'forceCopy' => true
    ];

    public $css = [
        'less/styles.css'
    ];

    public $js = [
    ];

    public function init()
    {
        $this->sourcePath = dirname(__FILE__) . '/assets';
        $this->sourcePath = __DIR__ . '/assets';
        parent::init();
    }
}

?>
