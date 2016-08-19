<?php

namespace humhub\modules\transport\controllers;

use humhub\modules\transport\models\PtmNode;
use humhub\modules\transport\models\PtmRouteNode;
use Yii;
use humhub\modules\transport\models\PtmSchedule;
use humhub\modules\transport\models\PtmScheduleSearch;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PtmScheduleController implements the CRUD actions for PtmSchedule model.
 */
class PtmScheduleController extends AdminController
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
     * Lists all PtmSchedule models.
     * @return mixed
     */
    public function actionIndex()
    {
        $this->getView()->pageTitle = 'Расписание';
        $this->getBreadCrumbs();
        $searchModel = new PtmScheduleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PtmSchedule model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $this->getBreadCrumbs();
        $nodesDataProvider = new ActiveDataProvider([
            'query' => PtmNode::find()->joinWith('ptmRouteNodes', ['id' => 'node_id'])->where(['route_id' => $id]),
        ]);
        $model = $this->findModel($id);
        $this->getView()->pageTitle = $model->route->name;

        return $this->render('view', [
            'model' => $model,
            'nodesDataProvider' => $nodesDataProvider
        ]);
    }

    /**
     * Creates a new PtmSchedule model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->getView()->pageTitle = 'Добавить расписание';
        $this->getBreadCrumbs();
        $model = new PtmSchedule();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing PtmSchedule model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $this->getBreadCrumbs();
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            $this->getView()->pageTitle = 'Изменить расписание по маршруту: ' . $model->route->name;

            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing PtmSchedule model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionDeleteNode($id)
    {
        PtmRouteNode::deleteAll(['route_id' => $this->id, 'node_id' => $id]);

        return $this->redirect(['view', 'id' => $this->id]);
    }

    /**
     * Finds the PtmSchedule model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PtmSchedule the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PtmSchedule::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
