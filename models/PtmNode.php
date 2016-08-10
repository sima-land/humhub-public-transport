<?php

namespace humhub\modules\transport\models;

use Yii;

/**
 * This is the model class for table "{{%ptm_node}}".
 *
 * @property integer $id
 * @property string $name
 * @property double $lat
 * @property double $lng
 *
 * @property PtmRouteNode[] $ptmRouteNodes
 */
class PtmNode extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%ptm_node}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['lat', 'lng'], 'number'],
            [['name'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Остановка',
            'lat' => 'Широта',
            'lng' => 'Долгота',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPtmRouteNodes()
    {
        return $this->hasMany(PtmRouteNode::className(), ['node_id' => 'id']);
    }

    public static function getAll()
    {
        $all = self::find()->select('id, name')->asArray()->all();
        $nodes = [];
        foreach ($all as $d) {
            $nodes[$d['id']] = $d['name'];
        }

        return $nodes;
    }
}
