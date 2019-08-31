<?php

namespace frontend\modules\products\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\StockProductItems;

/**
 * StockProductItemsSearch represents the model behind the search form about `common\models\StockProductItems`.
 */
class StockProductItemsSearch extends StockProductItems
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'group_id'], 'integer'],
            [['name', 'icon', 'size', 'weight', 'price_update'], 'safe'],
            [['price'], 'number'],
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
        $query = StockProductItems::find()->where(['deleted'=>10])->orderBy(['id'=>SORT_DESC]);

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
            'group_id' => $this->group_id,
            'price' => $this->price,
            'price_update' => $this->price_update,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'icon', $this->icon])
            ->andFilterWhere(['like', 'size', $this->size])
            ->andFilterWhere(['like', 'weight', $this->weight]);

        return $dataProvider;
    }
}
