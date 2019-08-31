<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Dbupdate as DbupdateModel;

/**
 * Dbupdate represents the model behind the search form about `backend\models\Dbupdate`.
 */
class Dbupdate extends DbupdateModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status', 'create_by', 'update_by', 'rstat'], 'integer'],
            [['sql', 'create_date', 'update_date'], 'safe'],
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
        $query = DbupdateModel::find()->orderBy(['id'=>SORT_ASC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 50,
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
            'create_date' => $this->create_date,
            'create_by' => $this->create_by,
            'update_date' => $this->update_date,
            'update_by' => $this->update_by,
            'rstat' => $this->rstat,
        ]);

        $query->andFilterWhere(['like', 'sql', $this->sql]);

        return $dataProvider;
    }
}
