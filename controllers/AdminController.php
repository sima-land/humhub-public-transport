<?php

namespace humhub\modules\transport\controllers;

use humhub\models\Setting;
use humhub\modules\transport\Assets;
use humhub\modules\transport\models\ConfigForm;
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
        $this->getView()->pageTitle = 'Администрирование';

        return $this->render('index');
    }

    public function actionConfig()
    {
        $this->getView()->pageTitle = 'Настройка модуля';
        $model = new ConfigForm(['is_shown' => Setting::Get('is_shown', 'transport')]);
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->is_shown = Setting::Set('is_shown', $model->is_shown, 'transport');

            return $this->redirect('config');
        }

        return $this->render('config', ['model' => $model]);
    }

    public function getBreadCrumbs()
    {
        \Yii::$app->view->params['breadcrumbs'][] = [
            'label' => 'Расписание автобусов',
            'url'   => Url::to(['/transport/main/index']),
        ];
        \Yii::$app->view->params['breadcrumbs'][] = [
            'label' => 'Администрирование',
            'url'   => Url::to(['/transport/admin/index']),
        ];
    }
}