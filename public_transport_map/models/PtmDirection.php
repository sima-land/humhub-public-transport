<?php

namespace humhub\modules\public_transport_map\models;

use Yii;

/**
 * This is the model class for table "ptm_direction".
 *
 * @property integer $id
 * @property string $description
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
        return 'ptm_direction';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['description'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('PublicTransportMapModule', 'ID'),
            'description' => Yii::t('PublicTransportMapModule', 'Description'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPtmRoutes()
    {
        return $this->hasMany(PtmRoute::className(), ['direction_id' => 'id']);
    }
}
