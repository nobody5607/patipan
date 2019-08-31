<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "options".
 *
 * @property int $id ID
 * @property string $label Label
 * @property string $value Value
 */
class Options extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'options';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['label'], 'required'],
            [['id'], 'integer'],
            [['value'], 'string'],
            [['label'], 'string', 'max' => 255],
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
            'label' => Yii::t('app', 'Label'),
            'value' => Yii::t('app', 'Value'),
        ];
    }
}
