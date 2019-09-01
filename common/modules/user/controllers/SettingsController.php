<?php
namespace common\modules\user\controllers;
use cpn\chanpan\utils\CNUtils;
use dektrium\user\controllers\SettingsController as BaseSettingsController;
use common\modules\user\models\Profile;
use common\modules\user\models\User;
use common\modules\admin\models\SettingsForm;
    
class SettingsController extends BaseSettingsController{
    //put your code here
    public function actionProfile() {
        
       
        $model = $this->finder->findProfileById(\Yii::$app->user->identity->getId());
        
        $userId = \common\modules\user\classes\CNUserFunc::getUserId();
        $name = \common\modules\user\classes\CNUserFunc::getFullName();
        
        if ($model == null) {
            $model = \Yii::createObject(Profile::className());
            $model->link('user', \Yii::$app->user->identity);
        }

        $event = $this->getProfileEvent($model);

        $this->performAjaxValidation($model);

        $this->trigger(self::EVENT_BEFORE_PROFILE_UPDATE, $event);
        if ($model->load(\Yii::$app->request->post())) {
            
            $model->avatar_path = isset($_POST['Profile']['path']) ? $_POST['Profile']['path'] : '';
            $model->avatar_base_url = isset($_POST['Profile']['base_url']) ? $_POST['Profile']['base_url'] : '';
                    
            if($model->save()){
                \backend\classest\KNLogFunc::addLog(1, "Update Profile", "แก้ไขข้อมูลส่วนตัว โดย: {$userId}:{$name} IP:".CNUtils::getCurrentIp());
                \Yii::$app->getSession()->setFlash('success', \Yii::t('user', 'Your profile has been updated'));
                $this->trigger(self::EVENT_AFTER_PROFILE_UPDATE, $event);
                return $this->refresh();
            }else{
                \yii\helpers\VarDumper::dump($model->errors, 10, true);exit();
            }
            
        }
        \backend\classest\KNLogFunc::addLog(1, "Preview Profile", "ดูข้อมูลส่วนตัว โดย: {$userId}:{$name} IP:".CNUtils::getCurrentIp());
        
        return $this->render('profile', [
                    'model' => $model,
        ]);
    }
    
    //accoute
    public function actionAccount() {
        /** @var SettingsForm $model */
        $model = \Yii::createObject(SettingsForm::className());
//        \appxq\sdii\utils\VarDumper::dump($model);

        $userId = \common\modules\user\classes\CNUserFunc::getUserId();
        $name = \common\modules\user\classes\CNUserFunc::getFullName();

        
        $event = $this->getFormEvent($model);

        $this->performAjaxValidation($model);

        $this->trigger(self::EVENT_BEFORE_ACCOUNT_UPDATE, $event);
        if ($model->load(\Yii::$app->request->post()) && $model->save()) {
            \backend\classest\KNLogFunc::addLog(1, "Edit Account", "แก้ไข Account โดย: {$userId}:{$name} IP:".CNUtils::getCurrentIp());
            \Yii::$app->session->setFlash('success', \Yii::t('user', 'Your account details have been updated'));
            $this->trigger(self::EVENT_AFTER_ACCOUNT_UPDATE, $event);
            return $this->refresh();
        }

        \backend\classest\KNLogFunc::addLog(1, "Account", "ดูหน้า Account โดย:{$userId}:{$name} IP:".CNUtils::getCurrentIp());
        return $this->render('account', [
                    'model' => $model,
        ]);
    }

}
