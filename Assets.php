<?php
/**
 * Linking assets.
 */
 
namespace humhub\modules\public_transport_map;

use yii\web\AssetBundle;

class Assets extends AssetBundle
{
    public $css = [
        'leaflet-routing-machine.css',
        'nodes.css',
        'adminPanel.css'
    ];
    public $js = [
        'map_script.js',
        'jquery.maskedinput.min.js'
    ];
    public function init()
    {
        $this->sourcePath = dirname(__FILE__) . '/assets';
        parent::init();
    }
}
?>
