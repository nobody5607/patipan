<?php

 
namespace cpn\chanpan\assets\jzoom;
 
class JZoomAsset extends \yii\web\AssetBundle{
    public $sourcePath='@cpn/chanpan/assets/jzoom/assets';
    public $css = [
    ];
    public $js = [
        'jquery.elevatezoom.js',
    ];
    public $depends=[
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
