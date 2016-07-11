<?php
/**
 * Created by PhpStorm.
 * User: pliska
 * Date: 11.07.16
 * Time: 10:15
 */

namespace humhub\modules\public_transport_map\controllers;

use humhub\modules\public_transport_map\models\PtmAuth;
use yii\web\Controller;
use yii\db;
use yii;


class AuthController extends ActiveRecord implements IdentityInterface
{

    
    public function actionAdminPanel() 
    {
        $login = $_POST['login'];
        $password = $_POST['password'];

        $admins = PtmAuth::find()
            ->where(['login'=>$login])
            ->all();
        return $this->render ('adminPanel', [
            'admins'=>$admins,
            'password'=>$password
        ]);
    }
 /*   public $login;

    public static function findByUsername($login)
    {
        $users = self::getAllUsers();
        foreach ($users as $user) {
            if (strcasecmp($user['login'], $login) === 0) {
                return new static($user);
            }
        }
        return null;
    }

    public static function getAllUsers()
    {
        $allusers = PtmAuth::find()->where('')->all();
    }*/
}