<?php

use humhub\modules\user\models\User;
use humhub\widgets\TopMenu;
use humhub\modules\user\widgets\ProfileHeaderControls;

return [
    'id' => 'transport',
    'class' => 'humhub\modules\transport\Module',
    'namespace' => 'humhub\modules\transport',
    'urlManagerRules' => [
            'transport' => 'transport/main/index',
            'transport/admin' => 'transport/admin/index',
            'transport/admin/schedule' => 'transport/ptm-schedule/index',
            'transport/admin/schedule/create' => 'transport/ptm-schedule/create',
            'transport/admin/schedule/update/<id:\d+>' => 'transport/ptm-schedule/update',
            'transport/admin/schedule/view/<id:\d+>' => 'transport/ptm-schedule/view',
            'transport/admin/route' => 'transport/ptm-route/index',
            'transport/admin/route/create' => 'transport/ptm-route/create',
            'transport/admin/route/update/<id:\d+>' => 'transport/ptm-route/update',
            'transport/admin/node' => 'transport/ptm-node/index',
            'transport/admin/node/create' => 'transport/ptm-node/create',
            'transport/admin/node/update/<id:\d+>' => 'transport/ptm-node/update',
            'transport/admin/node/view/<id:\d+>' => 'transport/ptm-node/view',
            'transport/admin/direction' => 'transport/ptm-direction/index',
            'transport/admin/direction/create' => 'transport/ptm-direction/create',
            'transport/admin/direction/update/<id:\d+>' => 'transport/ptm-direction/update',
    ],
    'events' => [
        [
            'class' => TopMenu::className(),
            'event'=> TopMenu::EVENT_INIT,
            'callback' => ['humhub\modules\transport\Events', 'onTopMenuInit']
        ]
    ],
];
?>
