<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    //'bootstrap' => ['log'],
    'language' => 'th-TH',//'en-US',
    'timeZone' => 'Asia/Bangkok',
    'bootstrap' => ['log', 'frontend\components\AppComponent',
        [
            'class' => 'common\components\LanguageSelector',
            'supportedLanguages' => ['en-US', 'th-TH'], //กำหนดรายการภาษาที่ support หรือใช้ได้
        ]    
    ],
    
    'controllerNamespace' => 'frontend\controllers',    
    'components' => [
//        'view' => [
//            'theme' => [
//                'pathMap' => [
//                   '@frontend/views' => '@frontend/themes/market'
//                ],
//            ],
//       ],
        'meta' => [
            'class' => 'frontend\components\MetaComponent',
        ],//seo config
        'request' => [
            'csrfParam' => '_csrf-frontend',
        ],
        'user' => [
            'identityClass' => 'dektrium\user\models\User',
            //'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
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
         
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                       '<controller:\w+>/<id:\d+>' => '<controller>/view',
                       '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                       '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
                       ['class' => 'yii\rest\UrlRule', 'controller' => 'location', 'except' => ['delete','GET', 'HEAD','POST','OPTIONS'], 'pluralize'=>false],
                       '<module:\w+>/<controller:\w+>/<action:\w+>' => '<module>/<controller>/<action>',
            ],
        ],
        
        //language
        'languagepicker' => [
            'class' => 'lajax\languagepicker\Component',
            'languages' => ['en-US', 'th-TH'], // List of available languages (icons only)
            'cookieName' => 'language', // Name of the cookie.
            'expireDays' => 64, // The expiration time of the cookie is 64 days.
            'callback' => function() {
                if (!\Yii::$app->user->isGuest) {
                    //		    $user = \Yii::$app->user->identity;
                    //		    $user->language = \Yii::$app->language;
                    //		    $user->save();
                }
            }
        ],
         
    ],
    'modules'=>[
        'user' => [
            'class' => 'dektrium\user\Module',
            'enableConfirmation' => FALSE,
            'enableUnconfirmedLogin' => true,
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
                'settings' => 'common\modules\user\controllers\SettingsController',
                'registration' => 'common\modules\user\controllers\RegistrationController',
                'security'=>'common\modules\user\controllers\SecurityController',
                'recovery'=>'common\modules\user\controllers\RecoveryController',
                
            ],
        ],
        'products' => [
            'class' => 'frontend\modules\products\modules',
        ],
    ],
    'params' => $params,
];
