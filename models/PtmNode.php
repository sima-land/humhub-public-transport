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
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    public $newName;
    public $newLat;
    public $newLng ;
    public $names = [];

    public static function tableName()
    {
        return 'ptm_node';
    }

    public function rules()
    {
        return [
            [['newName', 'newLat', 'newLng'], 'required'],
            [['newLat', 'newLng'], 'number'],
            [['newName'], 'string', 'max' => 40],
        ];
    }

    /*public function attributeLabels()
    {
        return [
            'id' => Yii::t('PublicTransportMapModule', 'ID'),
            'name' => Yii::t('PublicTransportMapModule', 'Name'),
            'lat' => Yii::t('PublicTransportMapModule', 'Lat'),
            'lng' => Yii::t('PublicTransportMapModule', 'Lng'),
        ];
    }*/

    public function getPtmRouteNodes()
    {
        return $this->hasMany(PtmRouteNode::className(), ['node_id' => 'id']);
    }

    public function getRoutes()
    {
        return $this->hasMany(PtmRoute::className(), ['id' => 'route_id'])->viaTable('ptm_route_node', ['node_id' => 'id']);
    }

    public function getNewName()
    {
        return $this->newName;
    }

    public function getNewLat()
    {
        return $this->newLat;
    }

    public function getNewLng()
    {
        return $this->newLng;
    }

    public function Clear()
    {
        $this->newName = '';
        $this->newLat = '';
        $this->newLng = '';
    }
}
