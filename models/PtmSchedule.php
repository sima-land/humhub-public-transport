<?php

namespace humhub\modules\transport\models;

use Yii;

/**
 * This is the model class for table "{{%ptm_schedule}}".
 *
 * @property integer $id
 * @property string $departure_at
 * @property integer $route_id
 * @property string $comment
 *
 * @property PtmRoute $route
 */
class PtmSchedule extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%ptm_schedule}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['departure_at'], 'safe'],
            [['route_id'], 'integer'],
            [['comment'], 'string'],
            [['route_id'], 'exist', 'skipOnError' => true, 'targetClass' => PtmRoute::className(), 'targetAttribute' => ['route_id' => 'id']],
            [['departure_at'], 'filter', 'filter' => function($value) {
                return "0000-00-00 $value:00";
            }]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'departure_at' => 'Время отправления',
            'route_id' => 'Название маршрута',
            'comment' => 'Комментарий',
            'route.name' => 'Название маршрута',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRoute()
    {
        return $this->hasOne(PtmRoute::className(), ['id' => 'route_id']);
    }
}
