<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'name'=>'APP',
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'language' => 'en-US',
    'timeZone' => 'Asia/Bangkok',
    'bootstrap' => ['log',
        'backend\components\AppComponent',
        [ 
            'class' => 'common\components\LanguageSelector',
            'supportedLanguages' => ['en-US', 'th-TH'], //กำหนดรายการภาษาที่ support หรือใช้ได้
        ]
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'user' => [
            //'identityClass' => 'app\models\User',
            'identityClass' => 'dektrium\user\models\User',
            'enableAutoLogin' => true,
        ],
//        'view' => [
//            'theme' => [
//                'pathMap' => [
//                    '@app/views' => '@backend/themes/adminlte/views',
//                   // '@dektrium/user/views' => '@app/views/user'
//                ]
//            ]
//        ],
        
        'session' => [ 
            'name' => 'advanced-backend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ], 
        
        
 
         
    ],
    'modules'=>[
        'gridview' =>  [
                'class' => '\kartik\grid\Module'
        ],
        'core' => [
            'class' => 'backend\modules\core\Module',
        ],
//        'admin' => [
//            'class' => 'mdm\admin\Module',
//            'layout' => '@app/views/layouts/main.php',
//            'controllerMap' => [
//                'role'=>'common\modules\admin\controllers\RoleController',
//                'user' => 'common\modules\admin\controllers\AdminController',
//                'assignment' => [
//                    'class' => 'common\modules\admin\controllers\AssignmentController',
//                    'userClassName' => 'dektrium\user\models\User', 
//                ]
//            ],
//            
//        ],
         'admin' => [
            'class' => 'mdm\admin\Module',
            //'layout' => 'left-menu', // defaults to null, using the application's layou
            'layout' => '@app/views/layouts/main.php',
            'controllerMap' => [
                'assignment' => [
                    'class' => 'mdm\admin\controllers\AssignmentController',
                //'userClassName' => 'common\modules\user\models\User', // fully qualified class name of your User model
                // Usually you don't need to specify it explicitly, since the module will detect it automatically
                //'idField' => 'user_id',        // id field of your User model that corresponds to Yii::$app->user->id
                //'usernameField' => 'username', // username field of your User model
                //'searchClass' => 'app\models\UserSearch'    // fully qualified class name of your User model for searching
                ]
            ],
        ],
        'user' => [
            'class' => 'dektrium\user\Module',
            'enableConfirmation' => FALSE,
            'enableUnconfirmedLogin' => true,
//            'enableAutoLogin' => false,
            'confirmWithin' => 21600,
            'cost' => 12,
            'admins' => ['admin'],//admin
            'modelMap' => [
                'User' => 'common\modules\user\models\User',
                'Profile' => 'common\modules\user\models\Profile',
                'RegistrationForm' => 'common\modules\user\models\RegistrationForm',
                'RecoveryForm' =>'common\modules\user\models\RecoveryForm'
            ],
            
            'controllerMap' => [
                'admin' => 'common\modules\user\controllers\AdminController',
                'settings' => 'common\modules\user\controllers\SettingsController',
                'registration' => 'common\modules\user\controllers\RegistrationController',
                'security'=>'common\modules\user\controllers\SecurityController',
                'recovery'=>'common\modules\user\controllers\RecoveryController',
                
            ],
        ],
        
    ],
    'as access' => [
        'class' => 'mdm\admin\components\AccessControl',
        'allowActions' => [
            //module, controller, action ที่อนุญาตให้ทำงานโดยไม่ต้องผ่านการตรวจสอบสิทธิ์
            'site/*',
            'user/registration/register',
            'user/recovery/request',
            'user/recovery/reset',
            'informations/index',
            'api/*',
            'student/update',
            'core/file-storage/avatar-upload', 
        ]
    ],
    'params' => $params,
];
