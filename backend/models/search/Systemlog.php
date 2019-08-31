<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Systemlog as SystemlogModel;

/**
 * Systemlog represents the model behind the search form about `backend\models\Systemlog`.
 */
class Systemlog extends SystemlogModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'logtype', 'rstat', 'create_by', 'update_by'], 'integer'],
            [['logname', 'logdetail', 'create_date', 'update_date'], 'safe'],
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
        $query = SystemlogModel::find()->orderBy(['id'=>SORT_DESC]);

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
            'logtype' => $this->logtype,
            'rstat' => $this->rstat,
            'create_by' => $this->create_by,
            'create_date' => $this->create_date,
            'update_by' => $this->update_by,
            'update_date' => $this->update_date,
        ]);

        $query->andFilterWhere(['like', 'logname', $this->logname])
            ->andFilterWhere(['like', 'logdetail', $this->logdetail]);

        return $dataProvider;
    }
}
