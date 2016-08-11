<?php

namespace humhub\modules\transport\models;

use Yii;

/**
 * This is the model class for table "{{%ptm_route}}".
 *
 * @property integer $id
 * @property string $name
 * @property integer $direction_id
 *
 * @property PtmDirection $direction
 * @property PtmRouteNode[] $ptmRouteNodes
 * @property PtmSchedule[] $ptmSchedules
 */
class PtmRoute extends \yii\db\ActiveRecord
{
    public $nodes_arr = [];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%ptm_route}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['direction_id'], 'integer'],
            [['name'], 'string', 'max' => 100],
            [['direction_id'], 'exist', 'skipOnError' => true, 'targetClass' => PtmDirection::className(), 'targetAttribute' => ['direction_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'direction_id' => 'Направление',
            'nodesArr' => 'Остановки:',
            'direction.name' => 'Направление'
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

    public function getNodesArr()
    {
        $nodes = [];
        foreach ($this->nodes as $node) {
            $nodes[] = $node->id;
        }
        return $nodes;
    }

    public static function getAll()
    {
        $all = self::find()->select('id, name')->asArray()->all();
        $routes = [];
        foreach ($all as $d) {
            $routes[$d['id']] = $d['name'];
        }

        return $routes;
    }
}
