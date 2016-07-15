<?php
namespace humhub\modules\public_transport_map\controllers;

use humhub\modules\public_transport_map\models\PtmAuth;
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

/**
 * Default controller for the `Public transport map` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */

    private $name;


    public function actionIndex()
    {
        $id = 0;
        $nodeNameArr = [];
        $nodeLatArr = [];
        $nodeLngArr = [];
        $current_date = date('Y-m-d');

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

    public function actionRouteRefresh($id, $current_date)//для ajax запросов от index
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

    public function actionAdminPanel()
    {
        $newRoute = new PtmRoute();//adds a new route and stops from $newNode
        $newRouteNode = new PtmRouteNode();

        $newNode = new PtmNode();//adds new nodes (stops)

        $model = new PtmAuth();

        //newRoute : newID newDirectionID newTitle
        //newRouteNode : newRouteID newNodeID newNodeInterval

        //newDirectionID = INPUT | newTitle = INPUT | newID:AUTO_INCREMENT
        //newRouteID = newID | newNodeID = (here will be array of nodes) | newNodeInterval = ( ! INPUT )


        $dataNode = $newNode->load(Yii::$app->request->post());
        $dataAuth = $model->load(Yii::$app->request->post());

        $login = $model->getLogin();
        $password = $model->getPassword();

        if ($dataNode) $this->name = $newNode->getNewName();

        $admin = PtmAuth::find()
            ->where([
                'login' => $login,
                'password' => $password
            ])
            ->all();

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

        if ($dataAuth && $admin) {
            //$_SESSION['admin'] = $admin[0];
            return $this->render('adminPanelLogged', [
                'model' => $model,
                'admin' => $admin,
                'newRoute' => $newRoute,
                'newRouteNode' => $newRouteNode,
                'newNode' => $newNode,
                'names' => $this->name
            ]);
        } else {
            return $this->render('adminPanel', [
                'model' => $model,
                'error_message' => $error_message,
                'newNode' => $newNode,
                'newRoute' => $newRoute,
                'newRouteNode' => $newRouteNode
            ]);
        }
    }

    public function actionAddRoute($nodeNamesReady, $nodeLatReady, $nodeLngReady, $nodeTimeReady, $routeDirection, $routeTitle)
    {
        $lastRouteID = null;

        $message = 'Error';

        $maxNodeID = PtmNode::find()->max('id');
        $maxRouteID = PtmRoute::find()->max('id');


        //!! make a 'ALTER TABLE ptm_node AUTO_INCREMENT = $max' before inserts!!

//now we have to insert ( route_id, node_id, node_interval ) into ptm_route_node for all the inputed nodes
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
}