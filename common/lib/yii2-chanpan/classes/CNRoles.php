<?php
 
namespace cpn\chanpan\classes;
 
class CNRoles {
    public static function getAuthList() {
        try {
            $auth_str = (new \yii\db\Query())->select('*')->from('auth_item')->where(['type' => '1'])->all();
            return \yii\helpers\ArrayHelper::map($auth_str, 'name', 'description');
        } catch (\yii\db\Exception $e) {
            return $e->getMessage();
        }
    }
    public static function getAuthListByName($name) {
        try {
            
            $auth_str = (new \yii\db\Query())
                    ->select('*')
                    ->from('auth_item')
                    ->where('name=:name AND type=1',[':name'=>$name])
                    ->one();
            return isset($auth_str) ? $auth_str : '';
        } catch (\yii\db\Exception $e) {
            return $e->getMessage();
        }
    }
    public static function getAuthAssign($user_id) {
        try {
            $auth_str = (new \yii\db\Query())->select('*')->from('auth_assignment')->where(['user_id' => $user_id])->all();
            return \yii\helpers\ArrayHelper::map($auth_str, 'item_name', 'item_name');
        } catch (\yii\db\Exception $e) {
            \backend\modules\ezforms2\classes\EzfFunc::addErrorLog($e);
        }
    }
}
