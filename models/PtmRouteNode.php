<?php

namespace humhub\modules\public_transport_map\models;

use Yii;

/**
 * This is the model class for table "ptm_route_node".
 *
 * @property integer $route_id
 * @property integer $node_id
 * @property string $node_interval
 *
 * @property PtmNode $node
 * @property PtmRoute $route
 */
class PtmRouteNode extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ptm_route_node';
    }

    /**
     * @inheritdoc
     */
   /* public function rules()
    {
        return [
            [['route_id', 'node_id'], 'required'],
            [['route_id', 'node_id'], 'integer'],
            [['node_interval'], 'string'],
            [['node_id'], 'exist', 'skipOnError' => true, 'targetClass' => PtmNode::className(), 'targetAttribute' => ['node_id' => 'id']],
            [['route_id'], 'exist', 'skipOnError' => true, 'targetClass' => PtmRoute::className(), 'targetAttribute' => ['route_id' => 'id']],
        ];
    }*/

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'route_id' => Yii::t('PublicTransportMapModule', 'Route ID'),
            'node_id' => Yii::t('PublicTransportMapModule', 'Node ID'),
            'node_interval' => Yii::t('PublicTransportMapModule', 'Node Interval'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNode()
    {
        return $this->hasOne(PtmNode::className(), ['id' => 'node_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRoute()
    {
        return $this->hasOne(PtmRoute::className(), ['id' => 'route_id']);
    }
}
