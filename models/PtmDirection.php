<?php

namespace humhub\modules\transport\models;

use Yii;

/**
 * This is the model class for table "{{%ptm_direction}}".
 *
 * @property integer $id
 * @property string $name
 *
 * @property PtmRoute[] $ptmRoutes
 */
class PtmDirection extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%ptm_direction}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Название направления',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPtmRoutes()
    {
        return $this->hasMany(PtmRoute::className(), ['direction_id' => 'id']);
    }

    public static function getAll()
    {
        $all = self::find()->select('id, name')->asArray()->all();
        $directions = [];
        foreach ($all as $key => $d) {
            $directions[$d['id']] = $d['name'];
        }

        return $directions;
    }
}
