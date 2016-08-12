<?php

namespace humhub\modules\transport;

use yii\web\AssetBundle;

class Assets extends AssetBundle
{
    public $publishOptions = [
        'forceCopy' => true
    ];

    public $css = [
        'less/styles.css',
        'css/leaflet.css',
        'css/datetimePicker.min.css'
    ];

    public $js = [
        'js/map.js',
        'js/leaflet/leaflet.js',
        'js/datetimePicker/moment.min.js',
        'js/datetimePicker/bootstrap-datetimepicker.min.js',
    ];

    public function init()
    {
        $this->sourcePath = __DIR__ . '/assets';
        parent::init();
    }

    public $depends = [
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}
