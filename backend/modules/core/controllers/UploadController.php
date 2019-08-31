<?php
 
namespace backend\modules\core\controllers;
use Yii; 
class UploadController extends \yii\web\Controller{
  public function actions()
    { 
        return [
            'image-upload' => [
                'class' => 'vova07\imperavi\actions\UploadFileAction',
                'url' => Yii::getAlias('@storageUrl') . '/uploads', // Directory URL address, where files are stored.
                'path' => '@storage/web/uploads', // Or absolute path to directory where files are stored.
                    'validatorOptions' => [
                      'maxWidth' => 3000,
                      'maxHeight' => 3000
                  ],
            ],
            'file-upload' => [
                'class' => 'vova07\imperavi\actions\UploadFileAction',
                'url' => Yii::getAlias('@storageUrl') . '/uploads', // Directory URL address, where files are stored.
                'path' => '@storage/web/uploads', // Or absolute path to directory where files are stored.
                'uploadOnlyImage' => false,
                'validatorOptions' => [
                    'maxSize' => 500000000
                ]
            ],
            'files-get' => [
                'class' => 'appxq\sdii\action\GetAction',
                'url' => Yii::getAlias('@storageUrl') . '/uploads', // Directory URL address, where files are stored.
                'path' => '@storage/web/uploads', // Or absolute path to directory where files are stored.
                'type' => \appxq\sdii\action\GetAction::TYPE_FILES,
            ],
            'images-get' => [
                'class' => 'appxq\sdii\action\GetAction',
                'url' => Yii::getAlias('@storageUrl') . '/uploads', // Directory URL address, where files are stored.
                'path' => '@storage/web/uploads', // Or absolute path to directory where files are stored.
                'type' => \appxq\sdii\action\GetAction::TYPE_IMAGES,
                'options' => ['only' => ['*.jpg', '*.jpeg', '*.png', '*.gif', '*.ico']],
            ]
        ];
    }
}
