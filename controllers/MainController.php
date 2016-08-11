<?php

namespace humhub\modules\transport\controllers;

use humhub\modules\transport\models\PtmDirection;
use humhub\modules\transport\models\PtmSchedule;
use humhub\modules\user\models\User;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\View;

class MainController extends Controller
{
    public function actionIndex()
    {
        $is_t_admin = false;
        $user = User::findOne(\Yii::$app->user->id);
        foreach ($user->groups as $group) {
            if ($group->name == 'transport_admin') {
                $is_t_admin = true;
                break;
            }
        }

        $time_table = PtmSchedule::find()->all();
        $direction = [];
        foreach ($time_table as $route) {
            $nodes = [];
            foreach ($route->route->nodes as $node) {
                $nodes[] = $node->getAttributes();
            }
            $direction[] = [
                'id' => $route->id,
                'direction' => $route->route->direction->name,
                'departure_at' => $route->departure_at,
                'route_name' => $route->route->name,
                'comment' => $route->comment,
                'nodes' => $nodes
            ];
        }

        \Yii::$app->view->registerJs(
            $this->renderPartial(
                '/main/_js-data.php',
                [
                    'jsonDataList' => Json::encode($direction),
                ]
            ),
            View::POS_BEGIN,
            'nodes'
        );

        return $this->render('index', [
            'is_admin' => $is_t_admin,
            'directions' => PtmDirection::getAll(),
            'time_table' => $direction
        ]);
    }
}