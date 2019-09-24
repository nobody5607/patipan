<?php

namespace common\modules\user\controllers;

use cpn\chanpan\utils\CNUtils;
use dektrium\user\controllers\SecurityController as BaseSecurityController;
use common\modules\user\models\LoginForm;

class SecurityController extends BaseSecurityController {

    //put your code here
    public function actionLogin() {

        // $this->layout='@backend/themes/adminlte/views/layouts/main';
        if (!\Yii::$app->user->isGuest) {
            $this->goHome();
        }

        /** @var LoginForm $model */
        $model = \Yii::createObject(LoginForm::className());
        $event = $this->getFormEvent($model);

        $this->performAjaxValidation($model);

        $this->trigger(self::EVENT_BEFORE_LOGIN, $event);

        if ($model->load(\Yii::$app->getRequest()->post()) && $model->login()) {
            $userId = \common\modules\user\classes\CNUserFunc::getUserId();
            $name   = \common\modules\user\classes\CNUserFunc::getFullName();
            
            $this->trigger(self::EVENT_AFTER_LOGIN, $event);
            return $this->goBack();
        }

        \backend\classest\KNLogFunc::addLog(1, "Login form", "ผู้ใช้ทั่วไปเข้าหน้า Login IP: ".CNUtils::getCurrentIp());
        return $this->render('login', [
                    'model' => $model,
                    'module' => $this->module,
        ]);
    }

    public function actionLogout() {
        $event  = $this->getUserEvent(\Yii::$app->user->identity);
        $userId = \common\modules\user\classes\CNUserFunc::getUserId();
        $name   = \common\modules\user\classes\CNUserFunc::getFullName(); 
        \backend\classest\KNLogFunc::addLog(1, "Logout", "Logout โดย {$userId}:{$name} IP: ".CNUtils::getCurrentIp());
        $this->trigger(self::EVENT_BEFORE_LOGOUT, $event);

        \Yii::$app->getUser()->logout();

        $this->trigger(self::EVENT_AFTER_LOGOUT, $event);

        return $this->goHome();
    }

}
