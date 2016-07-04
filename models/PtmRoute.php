<?php

namespace humhub\modules\public_transport_map\models;

use Yii;

/**
 * This is the model class for table "ptm_route".
 *
 * @property integer $id
 * @property integer $direction_id
 * @property string $title
 *
 * @property PtmDirection $direction
 * @property PtmRouteNode[] $ptmRouteNodes
 * @property PtmNode[] $nodes
 * @property PtmSchedule[] $ptmSchedules
 */
class PtmRoute extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ptm_route';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['direction_id'], 'integer'],
            [['title'], 'string', 'max' => 50],
            [['direction_id'], 'exist', 'skipOnError' => true, 'targetClass' => PtmDirection::className(), 'targetAttribute' => ['direction_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('PublicTransportMapModule', 'ID'),
            'direction_id' => Yii::t('PublicTransportMapModule', 'Direction ID'),
            'title' => Yii::t('PublicTransportMapModule', 'Title'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDirection()
    {
        return $this->hasOne(PtmDirection::className(), ['id' => 'direction_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPtmRouteNodes()
    {
        return $this->hasMany(PtmRouteNode::className(), ['route_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNodes()
    {
        return $this->hasMany(PtmNode::className(), ['id' => 'node_id'])->viaTable('ptm_route_node', ['route_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPtmSchedules()
    {
        return $this->hasMany(PtmSchedule::className(), ['route_id' => 'id']);
    }
}
