<?php

namespace humhub\modules\transport\controllers;

use humhub\modules\user\models\User;
use yii\web\Controller;

class MainController extends Controller
{
    public function actionIndex()
    {
        $is_t_admin = false;
        $user = User::findOne(\Yii::$app->user->id);
        foreach ($user->groups as $group) {
            if ($group->name == 'transport_admin') {
                $is_t_admin = true;
                break;
            }
        }

        return $this->render('index', ['is_admin' => $is_t_admin]);
    }
}