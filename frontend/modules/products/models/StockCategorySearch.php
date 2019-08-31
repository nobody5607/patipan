<?php

namespace frontend\modules\products\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\StockCategory;

/**
 * StockCategorySearch represents the model behind the search form about `common\models\StockCategory`.
 */
class StockCategorySearch extends StockCategory
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'type', 'category_id', 'deleted'], 'integer'],
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
        $query = StockCategory::find();

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
            'type' => $this->type,
            'category_id' => $this->category_id,
            'deleted' => $this->deleted,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'icon', $this->icon])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
