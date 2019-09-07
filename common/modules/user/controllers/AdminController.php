<?php
namespace common\modules\user\controllers;
use dektrium\user\filters\AccessRule;
use appxq\sdii\utils\VarDumper;
use cpn\chanpan\utils\CNUtils;
use dektrium\user\controllers\AdminController as BaseAdminController;
use yii\helpers\Url;
use common\modules\user\models\UserSearch;
use common\modules\user\models\Profile;
use common\modules\user\models\User;
use yii\web\NotFoundHttpException;
use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\Html;

class AdminController extends BaseAdminController{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete'          => ['post'],
                    'confirm'         => ['post'],
                    'resend-password' => ['post'],
                    'block'           => ['post'],
                    'switch'          => ['post'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'ruleConfig' => [
                    'class' => AccessRule::className(),
                ],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['switch'],
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['admin','teacher'],
                    ],
                ],
            ],
        ];
    }
    public function actionIndex()
    {  
       
        Url::remember('', 'actions-redirect');
        $searchModel  = \Yii::createObject(UserSearch::className());
        $dataProvider = $searchModel->search(\Yii::$app->request->get());

        $userId = \common\modules\user\classes\CNUserFunc::getUserId();
        $name = \common\modules\user\classes\CNUserFunc::getFullName();
        \backend\classest\KNLogFunc::addLog(1, "User", "ดูหน้า User โดย: {$userId}:{$name} IP:".CNUtils::getCurrentIp());


        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel'  => $searchModel,
        ]);
    }
    public function actionCreate()
    {
        $model = new \common\modules\user\models\Teacher();
        if ($model->load(\Yii::$app->request->post())) {
            $data = \Yii::$app->request->post('Teacher'); 
            $user = new User();  
            $name = "{$data['fname']} {$data['lname']}";
            $user->id = time();
            $user->username = $data['username']; 
            $user->email = $data['email'];
            $user->confirmed_at = time(); 
            $user->created_at = time(); 
            $checkEmail = User::find()->where('email=:email',[':email'=>$data['email']])->one();
            if($checkEmail){
                return \cpn\chanpan\classes\CNMessage::getError("Email {$data['email']} ถูกใช้แล้ว");
            }
            $checkUsername = User::find()->where('username=:username',[':username'=>$data['username']])->one();
            if($checkUsername){
                return \cpn\chanpan\classes\CNMessage::getError("Username {$data['username']} ถูกใช้แล้ว");
            }
            
            $user->password = $data['password'];  //\Yii::$app->security->generatePasswordHash($data['password']);//Yii::$app->getSecurity()->generatePasswordHash($data['password']);
            $user->register();
            
            // $user->auth_key = \Yii::$app->security->generateRandomString();
            
            try{
                $user->save();
                $columns=[
                     'user_id'=>$user->id,
                     'name'=>$name,
                     'public_email'=>$user->email,
                     'firstname'=>$data['fname'],
                     'lastname'=>$data['lname'],
                     'tel' => $data['tel']
                 ];
                \Yii::$app->db->createCommand()->delete('profile', 'user_id=:id',[':id'=>$user->id])->execute();
                \Yii::$app->db->createCommand()->insert('profile', $columns)->execute();
                
            } catch (Exception $ex) {

            }
            return \cpn\chanpan\classes\CNMessage::getSuccess("เพิ่มครูสำเร็จ");
        }

        return $this->renderAjax('create', [
            'model' => $model,
        ]);
    }
    public function actionUpdateProfile($id)
    {
        
        if (Yii::$app->getRequest()->isAjax) {

            $userId = \common\modules\user\classes\CNUserFunc::getUserId();
            $name = \common\modules\user\classes\CNUserFunc::getFullName();
            $request = Yii::$app->request;
            Url::remember('', 'actions-redirect');
            $user    = $this->findModel($id);
            $profile = $user->profile; 
            if ($profile == null) {
                $profile = \Yii::createObject(Profile::className());
                $profile->link('user', $user);
            }
            $event = $this->getProfileEvent($profile);
            $this->trigger(self::EVENT_BEFORE_PROFILE_UPDATE, $event);

            if ($profile->load(\Yii::$app->request->post()) && $profile->save()) {
                $logUser="";
                if($profile){
                    $logUser = CNUtils::array2String(\Yii::$app->request->post());
                }
                \backend\classest\KNLogFunc::addLog(1, "User", "แก้ไข User {$logUser} โดย: {$userId}:{$name} IP:".CNUtils::getCurrentIp());
                $this->trigger(self::EVENT_AFTER_PROFILE_UPDATE, $event);
                return \cpn\chanpan\classes\CNMessage::getSuccess('Update successfully');
            }


            $logUser="";
            if($profile){
                $logUser = CNUtils::array2String($user->profile->attributes);
            }
            \backend\classest\KNLogFunc::addLog(1, "User", "เปิดฟอร์มแก้ไข User {$logUser} โดย: {$userId}:{$name} IP:".CNUtils::getCurrentIp());


            return $this->renderAjax('_profile', [
                        'user' => $user,
                        'profile' => $profile,
            ]);
        } else {
	    throw new NotFoundHttpException('Invalid request. Please do not repeat this request again.');
	}
    }
    public function actionDelete($id)
    {
        if ($id == \Yii::$app->user->getId()) {
            return \cpn\chanpan\classes\CNMessage::getError('You can not remove your own account');
        } else {
            $model = $this->findModel($id);
            $event = $this->getUserEvent($model);
            $this->trigger(self::EVENT_BEFORE_DELETE, $event);

            $userId = \common\modules\user\classes\CNUserFunc::getUserId();
            $name = \common\modules\user\classes\CNUserFunc::getFullName();
            $logUser = "";
            if($model){
                $logUser = CNUtils::array2String($model->profile->attributes);
            }
            \backend\classest\KNLogFunc::addLog(1, "User", "ลบ User {$logUser} โดย: {$userId}:{$name} IP:".CNUtils::getCurrentIp());
            $model->delete();
            $this->trigger(self::EVENT_AFTER_DELETE, $event);



            return \cpn\chanpan\classes\CNMessage::getSuccess('Delete successfully');
        }

        return $this->redirect(['index']);
    }
    
    public function actionData(){
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $users = (new yii\db\Query())->select('*')->from('systemlog')->where('logname=:logname', [':logname' => 'Login'])->groupBy(['create_by'])->all();
        $usersAll = (new yii\db\Query())->select('*')->from('systemlog')->where('logname=:logname', [':logname' => 'Login'])->all();

        $data = [];
        $series = [
            'name' => 'xxx',
            'colorByPoint' => true,
            'data' => []
        ];

        foreach ($users as $k => $v) {

            $user = \common\modules\user\classes\CNUserFunc::getUserById($v['create_by']);
            $user_id = $v['create_by'];
            $fname = isset($user->profile->firstname) ? $user->profile->firstname : '';
            $lname = isset($user->profile->lastname) ? $user->profile->lastname : '';
            $name = "{$fname} {$lname}";
            $userLogin = (new yii\db\Query())->select('*')->from('systemlog')
                            ->where('logname=:logname AND create_by=:user_id', [':logname' => 'Login', ':user_id' => $user_id])->all();

            $countUsersAll = count($usersAll);
            $countUserLogin = count($userLogin);
            $data[$k] = [
               // 'user_id' => $user_id,
                'name' => $name,
                'totalCount' => $countUsersAll,
                'countUserLogin' => $countUserLogin,
                'y' => ($countUserLogin / $countUsersAll) * 100,
            ];
        }
        $series['data'] = $data;
        return $series;
    }
    public function actionGraph()
    {
        return $this->renderAjax('graph'); 
    }
     
    
}
