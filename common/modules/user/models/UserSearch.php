<?php
 
namespace common\modules\user\models;
use dektrium\user\models\UserSearch as BaseUserSearch;
use yii\data\ActiveDataProvider;
class UserSearch extends BaseUserSearch{
    public $firstname;
    public $lastname;
    public $tel;
    public function rules()
    {
         
        return [
            'fieldsSafe' => [['id', 'username', 'email', 'registration_ip', 'created_at', 'last_login_at', 'firstname', 'lastname', 'tel'], 'safe'],
            'createdDefault' => ['created_at', 'default', 'value' => null],
            'lastloginDefault' => ['last_login_at', 'default', 'value' => null],
        ];
    }
    public function search($params)
    {
        $query = User::find();
        $query->joinWith(['profile']);
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['created_at' => SORT_DESC]],
        ]);

        $dataProvider->sort->attributes['firstname'] = [
            // The tables are the ones our relation are configured to
            // in my case they are prefixed with "tbl_"
            'asc' => ['profile.firstname' => SORT_ASC],
            'desc' => ['profile.firstname' => SORT_DESC],
        ];
        
        $dataProvider->sort->attributes['lastname'] = [
            // The tables are the ones our relation are configured to
            // in my case they are prefixed with "tbl_"
            'asc' => ['profile.lastname' => SORT_ASC],
            'desc' => ['profile.lastname' => SORT_DESC],
        ];
        
        $dataProvider->sort->attributes['tel'] = [
            // The tables are the ones our relation are configured to
            // in my case they are prefixed with "tbl_"
            'asc' => ['profile.tel' => SORT_ASC],
            'desc' => ['profile.tel' => SORT_DESC],
        ];
        
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $table_name = $query->modelClass::tableName();

        if ($this->created_at !== null) {
            $date = strtotime($this->created_at);
            $query->andFilterWhere(['between', $table_name . '.created_at', $date, $date + 3600 * 24]);
        }

        $query->andFilterWhere(['like', $table_name . '.username', $this->username])
              ->andFilterWhere(['like', $table_name . '.email', $this->email])
              ->andFilterWhere([$table_name . '.id' => $this->id])
                ->andFilterWhere(['like', 'profile.firstname', $this->firstname])
                ->andFilterWhere(['like', 'profile.lastname', $this->lastname])
                ->andFilterWhere(['like', 'profile.tel', $this->tel])
              ->andFilterWhere([$table_name . 'registration_ip' => $this->registration_ip]);

        return $dataProvider;
    }
}
