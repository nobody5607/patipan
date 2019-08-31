<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "skin".
 *
 * @property int $id
 * @property string $name
 * @property string $value
 * @property int $default
 */
class Skin extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'skin';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['default'], 'integer'],
            [['name', 'value'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'value' => Yii::t('app', 'Value'),
            'default' => Yii::t('app', 'Default'),
        ];
    }
}
