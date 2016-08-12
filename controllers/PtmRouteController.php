<?php

namespace humhub\modules\transport\controllers;

use humhub\modules\transport\models\PtmRouteNode;
use Yii;
use humhub\modules\transport\models\PtmRoute;
use humhub\modules\transport\models\PtmRouteSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\View;

/**
 * PtmRouteController implements the CRUD actions for PtmRoute model.
 */
class PtmRouteController extends AdminController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all PtmRoute models.
     * @return mixed
     */
    public function actionIndex()
    {
        $this->getBreadCrumbs();
        $searchModel = new PtmRouteSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new PtmRoute model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->getBreadCrumbs();
        $model = new PtmRoute();
        $post = Yii::$app->request->post();
        if ($model->load($post) && $model->save()) {
            if ($post['PtmRoute']['nodesArr']) {
                foreach ($post['PtmRoute']['nodesArr'] as $node) {
                    $n = new PtmRouteNode();
                    $n->route_id = $model->id;
                    $n->node_id = $node;
                    $n->save();
                }
            }

            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing PtmRoute model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $this->getBreadCrumbs();
        $model = $this->findModel($id);
        $nodes = [];
        foreach ($model->nodes as $node) {
            $nodes[] = $node->getAttributes();
        }
        \Yii::$app->view->registerJs(
            $this->renderPartial(
                '/admin/_js-node.php',
                [
                    'jsonNodeList' => json_encode($nodes),
                ]
            ),
            View::POS_BEGIN,
            'nodes'
        );

        $post = Yii::$app->request->post();
        if ($post) {
            if ($model->load($post) && $model->save()) {
                if ($post['PtmRoute']['nodesArr']) {
                    PtmRouteNode::deleteAll(['route_id' => $model->id]);
                    foreach ($post['PtmRoute']['nodesArr'] as $node) {
                        $n = new PtmRouteNode();
                        $n->route_id = $model->id;
                        $n->node_id = $node;
                        $n->save();
                    }
                }

                return $this->redirect(['index']);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing PtmRoute model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the PtmRoute model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PtmRoute the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PtmRoute::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
