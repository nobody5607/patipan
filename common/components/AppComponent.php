<?php
 
namespace common\components;
use Yii; 
use yii\helpers\Url;
class AppComponent {
    public static function menuLeft($moduleID, $controllerID, $actionID){
	$items = [
//            ['label' => 'Home', 'url' => ['/'],'active' => ($controllerID == 'site' && $actionID == 'index')?true:false],
//            ['label' => 'Bill Items', 'url' => ['/bill-items'],'active' => ($controllerID == 'bill-items')?true:false],
//            ['label' => 'Bill Packagers', 'url' => ['/bill-packagers'],'active' => ($controllerID == 'bill-packagers')?true:false],
//            ['label' => 'Bill Shop', 'url' => ['/bill-shop'],'active' => ($controllerID == 'bill-shop')?true:false],
//            ['label' => 'Bill Shippings', 'url' => ['/bill-shippings'],'active' => ($controllerID == 'bill-shippings')?true:false],
//            ['label' => 'Bill Chargers', 'url' => ['/bill-chargers'],'active' => ($controllerID == 'bill-chargers')?true:false],
            [
            'label' => 'Admin',
                'visible' => \Yii::$app->user->can('admin') ? true : false,
                'active'=>($moduleID == 'admin')?true:false,
                'items' => [
                     ['label' => 'Members', 'url' => ['/admin/user'],'active'=>($controllerID == 'role')?true:false],
                     ['label' => 'Assignments', 'url' => ['/admin'],'active'=>($controllerID == 'admin')?true:false],
                     ['label' => 'Route', 'url' => ['/admin/route'],'active'=>($controllerID == 'route')?true:false],
                     ['label' => 'Role', 'url' => ['/admin/role'],'active'=>($controllerID == 'role')?true:false],
                     
                      
                ],
            ],
           
        ];
        return $items;
    }
    public static function menuRight(){
        
        $items = [            
            [
                'label' => isset(Yii::$app->user->identity->profile->name) ? Yii::$app->user->identity->profile->name : '',
                'visible' => !Yii::$app->user->isGuest,
                'items' => [
                     ['label' => '<i class="fa fa-user"></i> '.Yii::t('chanpan','User Profile'), 'url' => ['/user/settings/profile']],
                     '<li class="divider"></li>', 
                     ['label' => '<i class="fa fa-sign-out"></i> '.Yii::t('chanpan','Logout'), 'url' => ['/user/security/logout'], 'linkOptions' => ['data-method' => 'post']],
                ],
            ],
            ['label' => "<i class='fa fa-sign-in'></i> ".Yii::t('backend','Sign up'), 'url' => ['/user/register'], 'visible' => Yii::$app->user->isGuest],
            ['label' => "<i class='fa fa-sign-in'></i> ".Yii::t('backend','Login'), 'url' => ['/user/login'], 'visible' => Yii::$app->user->isGuest],
        ];
        return $items;
    }
    public static function subMenu(){
        $items = [
            ['label' => 'Home', 'url' => ['site/index']],             
            ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
        ];
        return $items;
    }
    public static function slideToggleLeft(){              
        return \yii\helpers\Html::a("<span class='sr-only'></span>", '#', [
            'class'=>'sidebar-toggle',
            'data-toggle'=>'push-menu',
            'role'=>'button',
            'id'=>'iconslideToggle'
        ]);
    }
    public static function slideToggleRight(){  
        return 
        
        \yii\helpers\Html::button("<i class='fa fa-bars'></i>", [
            'class'=>'navbar-toggle',
            'data-toggle'=>'collapse',
            'data-target'=>'#cnNavbar',
            
        ]);
         
    }
}
