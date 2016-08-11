<?php

use humhub\modules\user\models\User;
use humhub\widgets\TopMenu;
use humhub\modules\user\widgets\ProfileHeaderControls;

return [
    'id' => 'transport',
    'class' => 'humhub\modules\transport\Module',
    'namespace' => 'humhub\modules\transport',
    'urlManagerRules' => [
        [
            'class' => 'humhub\modules\transport\components\UrlRule',

        ]
    ],
    'events' => [
        [
            'class' => User::className(),
            'event' => User::EVENT_BEFORE_DELETE,
            'callback' => ['humhub\modules\transport\Events', 'onUserDelete']
        ],
        [
            'class' => TopMenu::className(),
            'event'=> TopMenu::EVENT_INIT,
            'callback' => ['humhub\modules\transport\Events', 'onTopMenuInit']
        ]
    ],
];
?>
