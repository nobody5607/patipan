<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "systemlog".
 *
 * @property int $id
 * @property string $logname
 * @property int $logtype
 * @property string $logdetail
 * @property int $rstat
 * @property int $create_by
 * @property string $create_date
 * @property int $update_by
 * @property string $update_date
 */
class Systemlog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'systemlog';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            
            [['id', 'logtype', 'rstat', 'create_by', 'update_by'], 'integer'],
            [['logdetail'], 'string'],
            [['create_date', 'update_date','ip'], 'safe'],
            [['logname'], 'string', 'max' => 255],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'logname' => Yii::t('app', 'Logname'),
            'logtype' => Yii::t('app', 'Logtype'),
            'logdetail' => Yii::t('app', 'Logdetail'),
            'rstat' => Yii::t('app', 'Rstat'),
            'create_by' => Yii::t('app', 'Create By'),
            'create_date' => Yii::t('app', 'Create Date'),
            'update_by' => Yii::t('app', 'Update By'),
            'update_date' => Yii::t('app', 'Update Date'),
        ];
    }
}
