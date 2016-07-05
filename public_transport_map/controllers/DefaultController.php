<?php

namespace humhub\modules\public_transport_map\controllers;


use humhub\modules\public_transport_map\models\PtmNode;
use humhub\modules\public_transport_map\models\PtmSchedule;
use yii\data\Pagination;
use yii\web\Controller;
use yii\db;
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
        $current_date = date('Y-m-d');
        $end_date = date('Y-m-d', time()+86400*7);

        $schedule = PtmSchedule::find()->where(['=', 'date(start_at)', $current_date])->all();

        

        return $this->render('index', [
            'schedule'=>$schedule,
        ]);
    }

    public function actionListGenerator($date)
    {
        $url = \Yii::$app->request->url;
        $date = substr($url, -10, 10);
        $schedule = PtmSchedule::find()->where(['date(start_at)'=>$date])->all();

        $newTitles = [];
        $directions = [];

        for ($i = 0; $i < count($schedule); $i++)
        {
            $newTitles[$i] = $schedule[$i]->route->title;
            $directions[$i] = $schedule[$i]->route->direction_id;
        }

        return json_encode([$newTitles, $directions]);
    }

    public function actionNodesCollection($id) {
        $id = intval($_GET['id'])   ;

        $nodeNameArr = array();
        $nodeLatArr = array();
        $nodeLngArr = array();

        $current_date = date('Y-m-d');

        $schedule = PtmSchedule::find()->where(['date(start_at)'=>$current_date])->all();
        $nodes = PtmNode::find()->joinWith('ptmRouteNodes')->where(['ptm_route_node.route_id'=>$schedule[$id]->route_id])->all();

        for ($i=0; $i <count($nodes); $i++)
        {
            $nodeNameArr[$i] = $nodes[$i]->name;
            $nodeLatArr[$i] = $nodes[$i]->lat;
            $nodeLngArr[$i] = $nodes[$i]->lng;
        }
        echo $this->render('nodes', array('nodes'=>$nodes, 'schedule'=>$schedule, 'id'=>$id));

        $nodeNameArr = json_encode($nodeNameArr);
        $nodeLatArr = json_encode($nodeLatArr);
        $nodeLngArr = json_encode($nodeLngArr);

        echo $this->render('routesOnMap', array('nodeNameArr'=>$nodeNameArr, 'nodeLatArr'=>$nodeLatArr, 'nodeLngArr'=>$nodeLngArr));

        return;
    }
}

