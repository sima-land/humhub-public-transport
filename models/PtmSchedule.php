<?php

namespace humhub\modules\public_transport_map\models;

use Yii;

/**
 * This is the model class for table "ptm_schedule".
 *
 * @property integer $id
 * @property string $start_at
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
        return 'ptm_schedule';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['start_at'], 'safe'],
            [['route_id'], 'integer'],
            [['comment'], 'string'],
            [['route_id'], 'exist', 'skipOnError' => true, 'targetClass' => PtmRoute::className(), 'targetAttribute' => ['route_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('PublicTransportMapModule', 'ID'),
            'start_at' => Yii::t('PublicTransportMapModule', 'Start At'),
            'route_id' => Yii::t('PublicTransportMapModule', 'Route ID'),
            'comment' => Yii::t('PublicTransportMapModule', 'Comment'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRoute()
    {
        return $this->hasOne(PtmRoute::className(), ['id' => 'route_id']);
    }
    
    public function getStartAtDate()
    {
        return date('d.m', strtotime($this->start_at));
    }

    public function getStartAtTime()
    {
        return date('H:i', strtotime($this->start_at));
    }
    
}
