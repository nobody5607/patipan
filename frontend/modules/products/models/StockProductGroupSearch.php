<?php

namespace frontend\modules\products\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\StockProductGroup;

/**
 * StockProductGroupSearch represents the model behind the search form about `common\models\StockProductGroup`.
 */
class StockProductGroupSearch extends StockProductGroup
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'brand_id', 'category_id', 'deleted'], 'integer'],
            [['name', 'icon', 'description'], 'safe'],
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
        $query = StockProductGroup::find()->where(['deleted'=>10])->orderBy(['id'=>SORT_DESC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'brand_id' => $this->brand_id,
            'category_id' => $this->category_id,
            'deleted' => $this->deleted,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'icon', $this->icon])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
