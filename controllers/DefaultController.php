<?php
namespace humhub\modules\public_transport_map\controllers;

use humhub\modules\public_transport_map\models\PtmNode;
use humhub\modules\public_transport_map\models\PtmRoute;
use humhub\modules\public_transport_map\models\PtmRouteNode;
use humhub\modules\public_transport_map\models\PtmSchedule;
use yii\web\Controller;
use yii\db;
use yii\db\ActiveRecord;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use Yii;
use humhub\modules\user\models\User;

/**
 * Default controller for the `Public transport map` module
 */

/**
 * Sometimes route not shows.
 *
 * The problem is in leaflet routing machine server. Sometimes it not works.
 *
 * You may check an error type at http://www.liedman.net/leaflet-routing-machine/
 */
class DefaultController extends Controller
{


    public function actionIndex()
    {
        $id = 0;
        $nodeNameArr = [];
        $nodeLatArr = [];
        $nodeLngArr = [];
        $current_date = date('Y-m-d');

        $schedule = PtmSchedule::find()
            ->where(['date(start_at)' => $current_date])
            ->orderBy('date(start_at) DESC')
            ->all();

        //it is possible to add schedules automatically
        //firstly: check interval between now and the latest date in table schedule
        //secondary: refill the table if interval is lesser then 2 weeks
        //i did not have time for code it

        /*
        $maxDate = date_create_from_format('Y-m-d', PtmSchedule::find()->max('date(start_at)'));

        if (date_create_from_format('Y-m-d', date('Y-m-d')) < $maxDate) var_dump(date_diff(($maxDate), date_create_from_format('Y-m-d', date('Y-m-d')))->format('%d days'));
        */
        //end of auto filling schedule table

        $nodes = PtmNode::find()
            ->joinWith('ptmRouteNodes')
            ->where(['ptm_route_node.route_id' => $schedule[$id]->route_id])
            ->orderBy('node_interval ASC')
            ->all();

        $routeNode = PtmRouteNode::find()
            ->where(['ptm_route_node.route_id' => $schedule[$id]->route_id])
            ->orderBy('node_interval ASC')
            ->all();

        for ($i = 0; $i < count($nodes); $i++) {
            $nodeNameArr[$i] = $nodes[$i]->name;
            $nodeLatArr[$i] = $nodes[$i]->lat;
            $nodeLngArr[$i] = $nodes[$i]->lng;
        }

        $nodeNameArr = json_encode($nodeNameArr);
        $nodeLatArr = json_encode($nodeLatArr);
        $nodeLngArr = json_encode($nodeLngArr);

        return $this->render('index', [
            'nodes' => $nodes,
            'schedule' => $schedule,
            'id' => $id,
            'routeNode' => $routeNode,
            'nodeNameArr' => $nodeNameArr,
            'nodeLatArr' => $nodeLatArr,
            'nodeLngArr' => $nodeLngArr
        ]);
    }

    public function actionListGenerator($date)
    {
        $url = \Yii::$app->request->url;
        $date = substr($url, -10, 10);
        $schedule = PtmSchedule::find()->joinWith('route')->where(['date(start_at)' => $date])->orderBy('direction_id ASC')->all();
        $newTitles = [];
        $directions = [];
        for ($i = 0; $i < count($schedule); $i++) {
            $newTitles[$i] = $schedule[$i]->route->title;
            $directions[$i] = $schedule[$i]->route->direction->description;
        }
        return json_encode([$newTitles, $directions]);
    }

    public function actionNodesCollection($id, $current_date)
    {

        $id = intval($id);

        $nodeNameArr = [];
        $nodeLatArr = [];
        $nodeLngArr = [];

        $schedule = PtmSchedule::find()
            ->where(['date(start_at)' => $current_date])
            ->all();

        $nodes = PtmNode::find()
            ->joinWith('ptmRouteNodes')
            ->where(['ptm_route_node.route_id' => $schedule[$id]->route_id])
            ->orderBy('node_interval ASC')
            ->all();

        $routeNode = PtmRouteNode::find()
            ->where(['ptm_route_node.route_id' => $schedule[$id]->route_id])
            ->orderBy('node_interval ASC')
            ->all();

        for ($i = 0; $i < count($nodes); $i++) {
            $nodeNameArr[$i] = $nodes[$i]->name;
            $nodeLatArr[$i] = $nodes[$i]->lat;
            $nodeLngArr[$i] = $nodes[$i]->lng;
        }

        return $this->render('nodes', [
            'nodes' => $nodes,
            'schedule' => $schedule,
            'id' => $id,
            'routeNode' => $routeNode,
            'nodeNameArr' => $nodeNameArr,
            'nodeLatArr' => $nodeLatArr,
            'nodeLngArr' => $nodeLngArr
        ]);
    }

    public function actionRouteRefresh($id, $current_date)//for ajax request from index
    {
        $nodeNameArr = [];
        $nodeLatArr = [];
        $nodeLngArr = [];

        $schedule = PtmSchedule::find()
            ->where(['date(start_at)' => $current_date])
            ->all();
        $nodes = PtmNode::find()
            ->joinWith('ptmRouteNodes')
            ->where(['ptm_route_node.route_id' => $schedule[$id]->route_id])
            ->orderBy('node_interval ASC')
            ->all();

        for ($i = 0; $i < count($nodes); $i++) {
            $nodeNameArr[$i] = $nodes[$i]->name;
            $nodeLatArr[$i] = $nodes[$i]->lat;
            $nodeLngArr[$i] = $nodes[$i]->lng;
        }
        return json_encode([$nodeNameArr, $nodeLatArr, $nodeLngArr]);
    }

    public function actionAdminPanel($adminDBPanel = false)
    {
        if ($adminDBPanel == 'true') {

            $schedule = PtmSchedule::find()
                ->all();

            $routes = PtmRoute::find()
                ->all();

            $nodes = PtmNode::find()
                ->all();

            $routeNodes = PtmRouteNode::find()
                ->all();

            return $this->render('adminDBPanel', [
                'schedule' => $schedule,
                'routes' => $routes,
                'nodes' => $nodes,
                'routeNodes' => $routeNodes
            ]);

        } else {
            $newRoute = new PtmRoute();//adds a new route and stops from $newNode
            $newRouteNode = new PtmRouteNode();

            $newNode = new PtmNode();//adds new nodes (stops)


            //newRoute : newID newDirectionID newTitle
            //newRouteNode : newRouteID newNodeID newNodeInterval

            //newDirectionID = INPUT | newTitle = INPUT | newID:AUTO_INCREMENT(??)
            //newRouteID = newID | newNodeID = (here will be array of nodes) | newNodeInterval = ( ! INPUT )


            $dataNode = $newNode->load(Yii::$app->request->post());

            if ($dataNode) $this->name = $newNode->getNewName();

            $currentUserID = Yii::$app->user->id;
            $userGroup = User::findOne($currentUserID)->group->name;

            if ($userGroup == 'PublicTransportMap') $admin = true;
            else $admin = false;


            if ($dataNode) {
                //$newNode->Clear();
                return $this->render('adminPanelLogged', [
                    'newNode' => $newNode,
                    'newRoute' => $newRoute,
                    'newRouteNode' => $newRouteNode,
                    'names' => $this->name
                ]);
            }

            if (!$admin) $error_message = 'login and password do not match';

            if ($admin) {
                return $this->render('adminPanelLogged', [
                    'admin' => $admin,
                    'newRoute' => $newRoute,
                    'newRouteNode' => $newRouteNode,
                    'newNode' => $newNode,
                    'names' => $this->name
                ]);
            } else {
                return $this->render('adminPanel', [
                    'error_message' => $error_message,
                    'newNode' => $newNode,
                    'newRoute' => $newRoute,
                    'newRouteNode' => $newRouteNode
                ]);
            }
        }
    }

    public function actionAddRoute($nodeNamesReady, $nodeLatReady, $nodeLngReady, $nodeTimeReady, $routeDirection, $routeTitle)
    {
        $lastRouteID = null;

        $message = 'Error';

        $maxNodeID = PtmNode::find()->max('id');
        $maxRouteID = PtmRoute::find()->max('id');


        //!! make a 'ALTER TABLE ptm_node AUTO_INCREMENT = $max' before inserts!!
        //I could not do it. without AUTO_INCREMENT IDs will sets not in order

//here we have to insert ( route_id, node_id, node_interval ) into ptm_route_node for all the inputed nodes
        if (isset($nodeNamesReady) && isset($nodeLatReady) && isset($nodeLngReady) && isset($nodeTimeReady) && isset($routeDirection) && isset($routeTitle)) {

            $namesArr = json_decode($nodeNamesReady);
            $latArr = json_decode($nodeLatReady);
            $lngArr = json_decode($nodeLngReady);
            $timeArr = json_decode($nodeTimeReady);

            Yii::$app->db->createCommand()->insert('ptm_route', [
                'direction_id' => $routeDirection,
                'title' => $routeTitle
            ])->execute();

            $lastRouteID = PtmRoute::find()
                ->limit(1)
                ->orderBy('id DESC')
                ->all()[0]->id;//('SELECT  `id` FROM ptm_node ORDER BY id DESC LIMIT 1')

            for ($i = 0; $i < count($namesArr); $i++) {
                Yii::$app->db->createCommand()->insert('ptm_node', [
                    'name' => $namesArr[$i],
                    'lat' => $latArr[$i],
                    'lng' => $lngArr[$i]
                ])->execute();

                $lastNodeID = PtmNode::find()
                    ->limit(1)
                    ->orderBy('id DESC')
                    ->all()[0]->id;

                Yii::$app->db->createCommand()->insert('ptm_route_node', [
                    'route_id' => $lastRouteID,
                    'node_id' => $lastNodeID,
                    'node_interval' => $timeArr[$i]
                ])->execute();
            }

            $message = 'Success';
        } else {
            $message = 'Fill all the fields';
        }

        return $message;
    }

    public function actionDeleteRows($scheduleIDs, $routesIDs)
    {

        if (isset($routesIDs) || isset($scheduleIDs)) {

            if (isset($scheduleIDs)) {

                $scheduleID = json_decode($scheduleIDs);

                $i = 0;

                for ($i = 0; $i < count($scheduleID); $i++) {

                    $schedule = PtmSchedule::find()
                        ->where(['ptm_schedule.id' => $scheduleID[$i]])
                        ->all();

                    Yii::$app->db->createCommand()
                        ->delete('ptm_schedule', ['id' => $schedule[0]->id])
                        ->execute();

                }

            }

            if (isset($routesIDs)) {

                $routesID = json_decode($routesIDs);


                for ($j = 0; $j < count($routesID); $j++) {

                    $route = PtmRoute::find()
                        ->where(['ptm_route.id' => $routesID[$j]])
                        ->all();


                    $routeNode = PtmRouteNode::find()
                        ->where(['ptm_route_node.route_id' => $route[0]->id])
                        ->all();

                    $routeNodeID = [];
                    $i = 0;

                    foreach ($routeNode as $item) {
                        $routeNodeID[$i] = $item->node_id;
                        $i++;
                    }

                    foreach ($routesID as $item) {
                        Yii::$app->db->createCommand()
                            ->delete('ptm_route_node', ['route_id' => $item])
                            ->execute();
                    }

                    foreach ($routeNodeID as $item) {
                        Yii::$app->db->createCommand()
                            ->delete('ptm_node', ['id' => $item])
                            ->execute();
                    }

                    Yii::$app->db->createCommand()
                        ->delete('ptm_route', ['id' => $routesID[$j]])
                        ->execute();

                }
            }

            return 'success';
        }

        return 'error';
    }

    public function actionAddSchedule($date, $route, $comment)
    {

        $date = json_decode($date);
        $route = json_decode($route);
        $comment = json_decode($comment);

        $success = Yii::$app->db->createCommand()->insert('ptm_schedule', [
            'start_at' => $date,
            'route_id' => $route,
            'comment' => $comment
        ])->execute();

        return $success;
    }

}