<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Lessons as LessonsModel;

/**
 * Lessons represents the model behind the search form about `backend\models\Lessons`.
 */
class Lessons extends LessonsModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'section', 'create_by', 'update_by', 'rstat'], 'integer'],
            [['name', 'detail', 'create_date', 'update_date'], 'safe'],
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
        $query = LessonsModel::find()->orderBy(['forder'=>SORT_ASC]);

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
            'section' => $this->section,
            'create_by' => $this->create_by,
            'create_date' => $this->create_date,
            'update_by' => $this->update_by,
            'update_date' => $this->update_date,
            'rstat' => $this->rstat,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'detail', $this->detail]);

        return $dataProvider;
    }
}
