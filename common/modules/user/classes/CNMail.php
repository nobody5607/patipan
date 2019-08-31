<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace common\modules\user\classes;
use dektrium\user\models\Token;
use dektrium\user\models\User;
 
class CNMail {
   public static function sendMail(User $user, Token $token){
        
       $email_to = isset($user->email) ? $user->email : '';
       $user_id = isset($user->id) ? $user->id : '';
       $data = (new \yii\db\Query())->select('code')->from('token')->where('user_id=:user_id',[':user_id'=>$user_id])->one();
       $data['code'] = isset($data['code']) ? $data['code'] : '';
       $url = isset(\Yii::$app->params['backendUrl'])?\Yii::$app->params['backendUrl']:'';
       $conf_url = "{$url}/user/registration/confirm?id={$user_id}&code={$data['code']}";
           
       $title = "Welcome to nCRC accounts.";
       $detail = \backend\modules\core\classes\CoreFunc::getParams('email_register', 'url');
       $modelForm = ['name'=> isset($user->profile->name) ? $user->profile->name : '', 'url'=> isset($conf_url) ? $conf_url : '', 'verify_text'=> isset($conf_url) ? $conf_url : ''];
       $path = [];
            foreach ($modelForm as $key => $value) {
                $path["{" . $key . "}"] = $value;
            }
       $d = strtr($detail, $path); 
       
        return \dms\aomruk\classese\Notify::setNotify()
                        ->notify($title)
                        ->detail($d)
                        ->SendMailTemplateRegistration($email_to);
   }
   public static function sendRecoveryMessage(User $user, Token $token){
       $url = isset(\Yii::$app->params['backendUrl'])?\Yii::$app->params['backendUrl']:'';
       ///user/recovery/reset?id=1&code=W6oe2o1eWhCaLh4hBc01P9UlRP-JbwOR
       $conf_url = "{$url}/user/recovery/reset?id={$user['id']}&code={$token['code']}";
       $detail = isset(\Yii::$app->params['email_recover'])?\Yii::$app->params['email_recover']:'';//email_recover      
       $email_to = isset($user->email) ? $user->email : '';
       
       $modelForm = ['url'=>$conf_url];
       $path = [];
            foreach ($modelForm as $key => $value) {
                $path["{" . $key . "}"] = $value;
            }
       $d = strtr($detail, $path);
       
       //set_email recover_title 
       $recover_title = isset(\Yii::$app->params['recover_title'])?\Yii::$app->params['recover_title']:'';
       $set_email = isset(\Yii::$app->params['set_email'])?\Yii::$app->params['set_email']:'';
       //$title = "Complete password reset on nCRC";
       $setForm=[$set_email => $recover_title];
       
            $result = \Yii::$app->mailer->compose('@backend/mail/layouts/registration', [
                        'notify' => $recover_title,
                        'detail' =>$d,
                        'url' => $url,
                            //'conf_url'=>$conf_url
                    ])
                    ->setFrom($setForm)
                    ->setTo($email_to)
                    ->setSubject($recover_title)
                    ->send();
            return $result;
        
 
   }
    
}
