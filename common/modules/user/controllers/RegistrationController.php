<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace common\modules\user\controllers;

use dektrium\user\controllers\RegistrationController as BaseRegistrationController;
use common\modules\user\models\RegistrationForm;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use Yii;
 
class RegistrationController extends BaseRegistrationController
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    ['allow' => true, 'actions' => ['register', 'connect'], 'roles' => ['?']],
                    ['allow' => true, 'actions' => ['confirm', 'resend'], 'roles' => ['?', '@']],
                ],
                'denyCallback'  => function ($rule, $action) {
                    if($action->id == 'register'){
                        return $this->redirect('/user/settings/profile');
                    }
                    //\appxq\sdii\utils\VarDumper::dump($action->id);
                    //You are already a member
                },
            ],
        ];
    }
   
    public function actionRegister()
    {
       // \appxq\sdii\utils\VarDumper::dump('ok');
        if (!$this->module->enableRegistration) {
            throw new NotFoundHttpException;
        }

        $model = \Yii::createObject(RegistrationForm::className());
        //$this->performAjaxValidation($model);

        if ($model->load(\Yii::$app->request->post())) { 
            $username = isset($_POST['register-form']['username']) ? $_POST['register-form']['username'] : '';
            $email = isset($_POST['register-form']['email']) ? $_POST['register-form']['email'] : '';
            
            if(\common\modules\user\classes\CNUserFunc::checkUser('username', $username)){                
               \Yii::$app->session->setFlash('error', Yii::t('user', 'This username has already been taken'));
            }            
            if(\common\modules\user\classes\CNUserFunc::checkUser('email', $email)){
                \Yii::$app->session->setFlash('error', Yii::t('user', 'This email address has already been taken'));
            }            
            if($model->register()){
                return $this->render('message', [
                    'title'  => \Yii::t('chanpan', 'A message has been sent to your email address. It contains a confirmation link that you must click to complete registration.'),
                    'module' => $this->module,
                    'email'=>$model->email
                ]);   
            } 
        }

        return $this->render('register', [
            'model'  => $model,
            'module' => $this->module,
        ]);
    }
    
    public function actionConfirm($id, $code)
    {
        $user = $this->finder->findUserById($id);

        if ($user === null || $this->module->enableConfirmation == false) {
            throw new NotFoundHttpException();
        }

        $event = $this->getUserEvent($user);

        $this->trigger(self::EVENT_BEFORE_CONFIRM, $event);

        $user->attemptConfirmation($code);

        $this->trigger(self::EVENT_AFTER_CONFIRM, $event);
        return $this->redirect(['/site/index']);
//        return $this->render('/message', [
//            'title'  => \Yii::t('user', 'Account confirmation'),
//            'module' => $this->module,
//        ]);
    }
    
    public function actionResend()
    {
        if ($this->module->enableConfirmation == false) {
            throw new NotFoundHttpException();
        }

        /** @var ResendForm $model */
        $model = \Yii::createObject(\common\modules\user\models\ResendForm::className());
        $event = $this->getFormEvent($model);

        $this->trigger(self::EVENT_BEFORE_RESEND, $event);

        $this->performAjaxValidation($model);

        if ($model->load(\Yii::$app->request->post())) {
            
            if($model->resend()){
                $this->trigger(self::EVENT_AFTER_RESEND, $event);

                return $this->render('/message', [
                    'title'  => \Yii::t('user', 'A new confirmation link has been sent'),
                    'module' => $this->module,
                ]);
            }
            
        }

        if(\Yii::$app->request->isAjax){
            return $this->renderAjax('resend-ajax', [
                'model' => $model,
            ]);
        }else{
            return $this->render('resend', [
                'model' => $model,
            ]);
        }
    }
    
    

}
