<?php

namespace humhub\modules\transport\models;

use Yii;

class ConfigForm extends \yii\base\Model
{

    public $is_shown;

    /**
     * Declares the validation rules.
     */
    public function rules()
    {
        return [
            [
                'is_shown', 'boolean'
            ]
        ];
    }

    /**
     * Declares customized attribute labels.
     * If not declared here, an attribute would have a label that is
     * the same as its name with the first letter in upper case.
     */
    public function attributeLabels()
    {
        return array(
            'is_shown' => 'Показать всем',
        );
    }

}
