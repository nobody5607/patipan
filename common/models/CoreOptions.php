<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "core_options".
 *
 * @property string $option_name
 * @property string $option_label
 * @property string $option_value
 */
class CoreOptions extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'core_options';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['option_name'], 'required'],
            [['option_value'], 'string'],
            [['option_name', 'option_label'], 'string', 'max' => 255],
            [['option_name'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'option_name' => Yii::t('product', 'Option Name'),
            'option_label' => Yii::t('product', 'Option Label'),
            'option_value' => Yii::t('product', 'Option Value'),
        ];
    }
}
