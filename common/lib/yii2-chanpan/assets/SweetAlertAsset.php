<?php

 
namespace cpn\chanpan\assets;
 
class SweetAlertAsset extends \yii\web\AssetBundle{
    public $sourcePath='@cpn/chanpan/assets/sweetalert2';
    public $css = [
        'sweetalert2.min.css',
    ];
    public $js = [
        'sweetalert2.min.js',
    ];
    public $depends=[
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
