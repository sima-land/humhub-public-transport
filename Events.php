<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2015 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\public_transport_map;

use Yii;
use yii\helpers\Url;

/**
 * Description of Events
 *
 *
 */
class Events extends \yii\base\Object
{
    /**
     * On User delete, also delete all comments
     *
     * @param type $event
     */
    /**
     * On build of the TopMenu, check if module is enabled
     * When enabled add a menu item
     *
     * @param type $event
     */
    public static function onTopMenuInit($event)
    {
        if (Yii::$app->user->isGuest) {
            return;
        }

        $event->sender->addItem(array(
            'label' => Yii::t('PublicTransportMapModule.base', 'Bus Map'),
            'url' => Url::to(['/public_transport_map/default/index']),
            'icon' => '<i class="fa fa-bus"></i>',
            'isActive' => (Yii::$app->controller->module && Yii::$app->controller->module->id == 'bus_map'),
            'sortOrder' => 300,
        ));
    }

    
}
