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
            [['login', 'password'], 'required', 'message' => 'please fill all the fields']//,
            //[['login', 'password'], 'email']
        ];
    }

    public function attributeLabels() {
        return [
            'login' => 'Имя',
            'password' => 'Пароль'
        ];
    }

    public function getLogin()
    {
        return $this->login;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setLogin($login)
    {
        $this->login = $login;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

}