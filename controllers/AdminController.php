<?php

namespace humhub\modules\transport\controllers;

use humhub\modules\transport\Assets;
use Yii;
use yii\helpers\Url;
use yii\web\Controller;

class AdminController extends Controller
{
    public function init()
    {
        parent::init();
        Yii::$app->view->registerAssetBundle(Assets::className());
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function getBreadCrumbs()
    {
        \Yii::$app->view->params['breadcrumbs'][] = [
            'label' => 'Расписание автобусов',
            'url' => Url::to(['/transport/main/index']),
        ];
        \Yii::$app->view->params['breadcrumbs'][] = [
            'label' => 'Администрирование',
            'url' => Url::to(['/transport/admin/index']),
        ];
    }
}