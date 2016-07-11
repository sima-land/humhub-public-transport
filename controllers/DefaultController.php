<?php
namespace humhub\modules\public_transport_map\controllers;

use humhub\modules\public_transport_map\models\PtmAuth;
use humhub\modules\public_transport_map\models\PtmNode;
use humhub\modules\public_transport_map\models\PtmRouteNode;
use humhub\modules\public_transport_map\models\PtmSchedule;
use yii\web\Controller;
use yii\db;
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
       $id = intval($_GET['id']);

       $nodeNameArr = [];
       $nodeLatArr = [];
       $nodeLngArr = [];
       //$current_date = date('Y-m-d');

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

       for ($i=0; $i < count($nodes); $i++)
       {
           $nodeNameArr[$i] = $nodes[$i]->name;
           $nodeLatArr[$i] = $nodes[$i]->lat;
           $nodeLngArr[$i] = $nodes[$i]->lng;
       }

       return $this->render('nodes', array(
           'nodes'=>$nodes,
           'schedule'=>$schedule,
           'id'=>$id,
           'routeNode'=>$routeNode,
           'nodeNameArr'=>$nodeNameArr,
           'nodeLatArr'=>$nodeLatArr,
           'nodeLngArr'=>$nodeLngArr
       ));
   }

    public function actionRouteRefresh($id, $current_date)//для ajax запросов от index
    {
        $nodeNameArr = [];
        $nodeLatArr = [];
        $nodeLngArr = [];
        //$current_date = date('Y-m-d');

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
        $model = new PtmAuth();

        $data = $model->load(Yii::$app->request->post());

        $login = $model->getLogin();
        $password = $model->getPassword();

        $admin = PtmAuth::find()
            ->where([
                'login'=>$login,
                'password'=>$password
            ])
            ->all();

        if (!$admin) $error_message = 'login and password do not match';

        if ($data && $admin) {
            return $this->render('adminPanelLogined', [
                'model' => $model,
                'admin' => $admin
            ]);
        } else {
            return $this->render('adminPanel', [
                'model'=>$model,
                'error_message' => $error_message
            ]);
        }
    }

}