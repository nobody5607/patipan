<?php
return [
    'language'=>'en',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
        '@cpn/chanpan' => '@common/lib/yii2-chanpan',
        '@cpn/admin' => '@common/lib/yii2-admin',
        '@appxq/sdii' => '@common/lib/yii2-sdii',
         
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'timeZone' => 'Asia/Bangkok',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'urlManager' => [
	    'class' => 'yii\web\UrlManager',
	    'showScriptName' => false, // Disable index.php
	    'enablePrettyUrl' => true, // Disable r= routes
	    'rules' => [
                ''=>'site/index',
                'access-denied'=>'access-module/access-denied',
                //'site/config'=>'site/index',
		'<controller:\w+>/<id:\d+>' => '<controller>',
		'<controller:\w+>/<action:\w+>/<*:*>' => '<controller>/<action>/<*>',
		'<module:\w+>/<controller:\w+>/<id:\d+>' => '<module>/<controller>',
		'<module:\w+>/<controller:\w+>/<action:\w+>/<*:*>' => '<module>/<controller>/<action>/<*>',
	    ],
	],
        'authManager' => [
	    'class' => 'yii\rbac\DbManager',
	    'defaultRoles' => ['guest', 'user'],
	    'cache' => 'yii\caching\FileCache'
	],
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@backend/views' => '@backend/themes/adminlte/views',
                    '@mdm/admin/views' => '@common/modules/admin/views',
                    '@dektrium/user/views' => '@common/modules/user/views',
                ],
            ],
        ],
        
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
        'i18n' => [
            'translations' => [
                '*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@backend/messages',
                    'fileMap' => [
                        //'users' => 'users.php',
                    ],
                ],
                'frontend*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@frontend/messages',
                ],
            ],
        ],
        'fileStorage' => [
            'class' => '\trntv\filekit\Storage',
            'baseUrl' => '@storageUrl/source',
            'filesystem' => [
                'class' => 'common\components\filesystem\LocalFlysystemBuilder',
                'path' => '@storage/web/source'
            ],
            'as log' => [
                'class' => 'backend\modules\core\behaviors\FileStorageLogBehavior',
                'component' => 'fileStorage'
            ]
        ],
        
        'moduleFileStorage' => [
            'class' => '\trntv\filekit\Storage',
            'baseUrl' => '@storageUrl/module',
            'filesystem' => [
                'class' => 'common\components\filesystem\LocalFlysystemBuilder',
                'path' => '@storage/web/module'
            ],
            'as log' => [
                'class' => 'backend\modules\core\behaviors\FileStorageLogBehavior',
                'component' => 'moduleFileStorage'
            ]
        ],
    ],
];
