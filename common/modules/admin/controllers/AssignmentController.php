<?php

namespace common\modules\admin\controllers;
use Yii;
use mdm\admin\models\searchs\Assignment;
use mdm\admin\controllers\AssignmentController as BaseAssignmentController; 
class AssignmentController extends BaseAssignmentController
{
    public function actionIndex()
    {

        if ($this->searchClass === null) {
            $searchModel = new Assignment;
            $dataProvider = $searchModel->search(Yii::$app->getRequest()->getQueryParams(), $this->userClassName, $this->usernameField);
        } else {
            $class = $this->searchClass;
            $searchModel = new $class;
            $dataProvider = $searchModel->search(Yii::$app->getRequest()->getQueryParams());
        }
        
        return $this->render('index', [
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel,
                'idField' => $this->idField,
                'usernameField' => $this->usernameField,
                'extraColumns' => $this->extraColumns,
        ]);
    }
}
