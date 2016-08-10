<?php

namespace humhub\modules\transport\controllers;

use Yii;
use humhub\modules\transport\models\PtmDirectionSearch;
use humhub\modules\user\models\User;
use yii\helpers\Url;
use yii\web\Controller;

class AdminController extends Controller
{
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