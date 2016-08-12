<?php

namespace humhub\modules\transport\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use humhub\modules\transport\models\PtmNode;

/**
 * PtmNodeSearch represents the model behind the search form about `humhub\modules\transport\models\PtmNode`.
 */
class PtmNodeSearch extends PtmNode
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['name'], 'safe'],
            [['lat', 'lng'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = PtmNode::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'lat' => $this->lat,
            'lng' => $this->lng,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
