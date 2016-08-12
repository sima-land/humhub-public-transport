<?php

namespace humhub\modules\transport;

use humhub\models\Setting;
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
     * On build of the TopMenu, check if module is enabled
     * When enabled add a menu item
     *
     * @param type $event
     */
    public static function onTopMenuInit($event)
    {
        $not_admin = true;
        $groups = Yii::$app->user->getIdentity()->groups;
        foreach ($groups as $group) {
            if ($group->name == 'transport_admin') {
                $not_admin = false;
                break;
            }
        }
        if (Yii::$app->user->isGuest || (Setting::Get('is_shown', 'transport') == 0 && $not_admin)) {
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
}
