<?php

namespace humhub\modules\public_transport_map\controllers;

use yii\web\Controller;

/**
 * Default controller for the `Public Transport Map` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
