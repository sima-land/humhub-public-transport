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
        $nodeNameArr =[];
        $nodeLatArr = [];
        $nodeLngArr = [];
        $current_date = date('Y-m-d');

        $schedule = PtmSchedule::find()
            ->where(['date(start_at)'=>$current_date])
            ->all();
        $nodes = PtmNode::find()
            ->joinWith('ptmRouteNodes')
            ->where(['ptm_route_node.route_id'=>$schedule[$id]->route_id])
            ->orderBy('node_interval ASC')
            ->all();
        $routeNode = PtmRouteNode::find()
            ->where(['ptm_route_node.route_id'=>$schedule[$id]->route_id])
            ->orderBy('node_interval ASC')
            ->all();

        for ($i=0; $i <count($nodes); $i++)
        {
            $nodeNameArr[$i] = $nodes[$i]->name;
            $nodeLatArr[$i] = $nodes[$i]->lat;
            $nodeLngArr[$i] = $nodes[$i]->lng;
        }
        $nodeNameArr = json_encode($nodeNameArr);
        $nodeLatArr = json_encode($nodeLatArr);
        $nodeLngArr = json_encode($nodeLngArr);
        
        return $this->render('index', [
            'nodes'=>$nodes,
            'schedule'=>$schedule,
            'id'=>$id,
            'routeNode'=>$routeNode,
            'nodeNameArr'=>$nodeNameArr,
            'nodeLatArr'=>$nodeLatArr,
            'nodeLngArr'=>$nodeLngArr
        ]);
    }
    public function actionListGenerator($date)
    {
        $url = \Yii::$app->request->url;
        $date = substr($url, -10, 10);
        $schedule = PtmSchedule::find()->joinWith('route')->where(['date(start_at)'=>$date])->orderBy('direction_id ASC')->all();
        $newTitles = [];
        $directions = [];
        for ($i = 0; $i < count($schedule); $i++)
        {
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
           ->where(['date(start_at)'=>$current_date])
           ->all();
       $nodes = PtmNode::find()
           ->joinWith('ptmRouteNodes')
           ->where(['ptm_route_node.route_id'=>$schedule[$id]->route_id])
           ->orderBy('node_interval ASC')
           ->all();
       $routeNode = PtmRouteNode::find()//========================================================
           ->where(['ptm_route_node.route_id'=>$schedule[$id]->route_id])
           ->orderBy('node_interval ASC')
           ->all();

       for ($i = 0; $i < count($nodes); $i++)
       {
           $nodeNameArr[$i] = $nodes[$i]->name;
           $nodeLatArr[$i] = $nodes[$i]->lat;
           $nodeLngArr[$i] = $nodes[$i]->lng;
       }

       return $this->render('nodes', [
           'nodes'=>$nodes,
           'schedule'=>$schedule,
           'id'=>$id,
           'routeNode'=>$routeNode,
           'nodeNameArr'=>$nodeNameArr,
           'nodeLatArr'=>$nodeLatArr,
           'nodeLngArr'=>$nodeLngArr
       ]);
   }

    public function actionRouteRefresh($id, $current_date)//для ajax запросов от index
    {
        $nodeNameArr = [];
        $nodeLatArr = [];
        $nodeLngArr = [];

        $schedule = PtmSchedule::find()
            ->where(['date(start_at)'=>$current_date])
            ->all();
        $nodes = PtmNode::find()
            ->joinWith('ptmRouteNodes')
            ->where(['ptm_route_node.route_id'=>$schedule[$id]->route_id])
            ->orderBy('node_interval ASC')
            ->all();

        for ($i=0; $i < count($nodes); $i++)
        {
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

        //$this->names[0] = null;

        //here i need an array of parameters for making all checks before insert

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
                'login'=>$login,
                'password'=>$password
            ])
            ->all();

        if ($dataNode) {
            /*Yii::$app->db->createCommand()->insert('ptm_node', [
                'name' => $newNode->getNewName(),
                'lat' => $newNode->getNewLat(),
                'lng' => $newNode->getNewLng()
            ])->execute();*/
            $newNode->Clear();
            return $this->render('adminPanelLogined', [
                'newNode' => $newNode,
                'newRoute' => $newRoute,
                'newRouteNode' => $newRouteNode,
                'names' => $this->name
            ]);
        }

        if (!$admin) $error_message = 'login and password do not match';

        if ($dataAuth && $admin) {
            //$_SESSION['admin'] = $admin[0];
            return $this->render('adminPanelLogined', [
                'model' => $model,
                'admin' => $admin,
                'newRoute' => $newRoute,
                'newRouteNode' => $newRouteNode,
                'newNode' => $newNode,
                'names' => $this->name
            ]);
        } else {
            return $this->render('adminPanel', [
                'model'=>$model,
                'error_message' => $error_message,
                'newNode' => $newNode,
                'newRoute' => $newRoute,
                'newRouteNode' => $newRouteNode
            ]);
        }
    }

    public function actionAdminPanelLogined()
    {
        var_dump("f"); exit();
        //$newNode = new PtmNode();

        //$data = $newNode->load(Yii::$app->request->post());

        //$lat = $newNode->getNewLat();
        //$lng = $newNode->getNewLng();
        $name = 5;

        //here will be queries to DB

        return $this->render('adminPanelLogined', [
            'f' => '77'
        ]);
    }

}