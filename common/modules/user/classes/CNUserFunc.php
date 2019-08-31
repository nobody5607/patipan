<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace common\modules\user\classes;
use Yii;
/**
 * Description of CNUser
 *
 * @author Sammy Guergachi <sguergachi at gmail.com>
 */
class CNUserFunc {
    public static function getFullName(){
        $fname = isset(Yii::$app->user->identity->profile->firstname) ? Yii::$app->user->identity->profile->firstname : '';
	$lname = isset(Yii::$app->user->identity->profile->lastname) ? Yii::$app->user->identity->profile->lastname : '';
        $fullName = "{$fname} {$lname}";
        return $fullName;
    }
     public static function getImagePath(){
        $storageUrl = isset(\Yii::$app->params['storageUrl']) ? \Yii::$app->params['storageUrl'] : '';
        $img = isset(Yii::$app->user->identity->profile->avatar_path) ? Yii::$app->user->identity->profile->avatar_path : '';

        if ($img == '') {
            $img = $storageUrl.'/images/user.png';
        } else {
            $img = "{$storageUrl}/source/{$img}";
        }
        return $img;
    }

    public static function getUserById($user_id){        
        return CNUserQuery::getUserById($user_id);
    }
    public static function getUserId(){        
        return isset(Yii::$app->user->id)?Yii::$app->user->id:'';
    }
    
    
    public static function createUser($type,$user){        
        return CNUserQuery::saveUser($type, $user);
    }
    public static function checkUser($field, $values){
        $data = \common\modules\user\models\User::find();
        if($field=="email"){
            $user = $data->where('email=:email', [':email'=>$values]);
        }else if($field=="username"){
            $user = $data->where('username=:username', [':username'=>$values]);
        }
        return $user->one();
        
    }
}
