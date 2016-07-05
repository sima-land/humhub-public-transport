<?php

namespace humhub\modules\public_transport_map\models;

use Yii;

/**
 * This is the model class for table "ptm_node".
 *
 * @property integer $id
 * @property string $name
 * @property double $lat
 * @property double $lng
 *
 * @property PtmRouteNode[] $ptmRouteNodes
 * @property PtmRoute[] $routes
 */
class PtmNode extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ptm_node';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['lat', 'lng'], 'number'],
            [['name'], 'string', 'max' => 40],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('PublicTransportMapModule', 'ID'),
            'name' => Yii::t('PublicTransportMapModule', 'Name'),
            'lat' => Yii::t('PublicTransportMapModule', 'Lat'),
            'lng' => Yii::t('PublicTransportMapModule', 'Lng'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPtmRouteNodes()
    {
        return $this->hasMany(PtmRouteNode::className(), ['node_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRoutes()
    {
        return $this->hasMany(PtmRoute::className(), ['id' => 'route_id'])->viaTable('ptm_route_node', ['node_id' => 'id']);
    }
}
