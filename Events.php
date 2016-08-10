<?php

namespace humhub\modules\transport;

use humhub\modules\user\models\User;
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
            'label' => "Расписание автобусов",
            'url' => Url::to(['/transport/main/index']),
            'icon' => '<i class="fa fa-bus"></i>',
            'isActive' => (Yii::$app->controller->module && Yii::$app->controller->module->id == 'public_transport_map'),
            'sortOrder' => 300,
        ));
    }
//    public static function onNotificationAddonInit($event)
//    {
//        if (Yii::$app->user->isGuest) {
//            return;
//        }
//        $event->sender->addWidget(Notifications::className(), array(), array('sortOrder' => 90));
//    }
}
