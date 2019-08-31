<?php

 
namespace cpn\chanpan\assets\footable;
 
class FooTableAsset extends \yii\web\AssetBundle{
    public $sourcePath='@cpn/chanpan/assets/footable';
    public $css = [
        'css/footable.bootstrap.min',
    ];
    public $js = [
        'js/footable.min'
    ];
    public $depends=[
         'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
