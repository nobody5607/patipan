<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "dbupdate".
 *
 * @property int $id
 * @property string $sql
 * @property int $status
 * @property string $create_date
 * @property int $create_by
 * @property string $update_date
 * @property int $update_by
 * @property int $rstat
 */
class Dbupdate extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dbupdate';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status', 'create_by', 'update_by', 'rstat'], 'integer'],
            [['sql'], 'string'],
            [['create_date', 'update_date','name'], 'safe'],
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
            'sql' => Yii::t('app', 'Sql'),
            'status' => Yii::t('app', 'Status'),
            'create_date' => Yii::t('app', 'Create Date'),
            'create_by' => Yii::t('app', 'Create By'),
            'update_date' => Yii::t('app', 'Update Date'),
            'update_by' => Yii::t('app', 'Update By'),
            'rstat' => Yii::t('app', 'Rstat'),
        ];
    }
}
