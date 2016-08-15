<?php

namespace humhub\modules\transport\controllers;

use humhub\modules\transport\Assets;
use humhub\modules\transport\models\PtmDirection;
use humhub\modules\transport\models\PtmRouteNode;
use humhub\modules\transport\models\PtmSchedule;
use humhub\modules\user\models\User;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\View;

class MainController extends Controller
{
    public function actionIndex()
    {
        \Yii::$app->view->registerAssetBundle(Assets::className());
        $is_t_admin = false;
        $groups = \Yii::$app->user->getIdentity()->groups;
        foreach ($groups as $group) {
            if ($group->name == 'transport_admin') {
                $is_t_admin = true;
                break;
            }
        }

        $time_table = PtmSchedule::find()->all();
        $direction = [];
        foreach ($time_table as $route) {
            $rn = PtmRouteNode::find()->where(['route_id' => $route->route_id])->orderBy('node_interval ASC')->all();
            $nodes = [];
            foreach ($rn as $n) {
                $attrs = $n->node->getAttributes();
                $attrs['time'] = $n->node_interval;
                $nodes[] = $attrs;
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