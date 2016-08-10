<?php

namespace humhub\modules\transport\models;

use Yii;

/**
 * This is the model class for table "{{%ptm_route_node}}".
 *
 * @property integer $id
 * @property integer $route_id
 * @property integer $node_id
 * @property integer $node_interval
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
        return '{{%ptm_route_node}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['route_id', 'node_id', 'node_interval'], 'integer'],
            [['node_id'], 'exist', 'skipOnError' => true, 'targetClass' => PtmNode::className(), 'targetAttribute' => ['node_id' => 'id']],
            [['route_id'], 'exist', 'skipOnError' => true, 'targetClass' => PtmRoute::className(), 'targetAttribute' => ['route_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'route_id' => 'Route ID',
            'node_id' => 'Node ID',
            'node_interval' => 'Node Interval',
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
