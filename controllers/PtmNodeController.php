<?php

namespace humhub\modules\transport\controllers;

use Yii;
use humhub\modules\transport\models\PtmNode;
use humhub\modules\transport\models\PtmNodeSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PtmNodeController implements the CRUD actions for PtmNode model.
 */
class PtmNodeController extends AdminController
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
     * Lists all PtmNode models.
     * @return mixed
     */
    public function actionIndex()
    {
        $this->getBreadCrumbs();
        $searchModel = new PtmNodeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PtmNode model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $this->getBreadCrumbs();

        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new PtmNode model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->getBreadCrumbs();
        $model = new PtmNode();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing PtmNode model.
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
     * Finds the PtmNode model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PtmNode the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PtmNode::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
