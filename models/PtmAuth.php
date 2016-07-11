<?php

namespace humhub\modules\public_transport_map\models;

use yii;


class PtmAuth extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'ptm_admin';
    }

    public $login;
    public $password;


    public function rules()
    {
        return [
            [['login', 'password'], 'required']//,
            //['password', 'validatePassword']
        ];
    }

 /*   public function validatePassword()
    {
        $user = $this->getUser();

        if (!$user || !$user->validatePassword($this->password)) {
            $this->addError('password', 'Password or username is not correct.');
        }
    }*/

    /**
     * @return bool
     */
 /*   public function login() {
        if ($this->validate()) {
            $user = AuthController::findByUsername($this->login);
            yii::$app->AuthController->login($user);
            return true;
        } else {
            return false;
        }
    }

    private function getUser()
    {
        if ($this->_user === false) {
            $this->_user = AuthController::findByUsername($this->login);
        }
        return $this->_user;
    }*/


    /**
     * @return mixed
     */
    public function getLogin()
    {
        return $this->login;
    }
    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }
    /**
     * @param mixed $login
     */
    public function setLogin($login)
    {
        $this->login = $login;
    }
    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

}