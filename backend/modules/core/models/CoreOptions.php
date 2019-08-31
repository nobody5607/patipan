<?php

namespace backend\modules\core\models;

use Yii;

/**
 * This is the model class for table "core_options".
 *
 * @property int $option_id ID
 * @property string $option_name Name
 * @property string $option_value Value
 * @property string $autoload Autoload
 * @property string $input_label Label
 * @property string $input_hint Hint
 * @property string $input_field Field
 * @property string $input_specific Specific
 * @property string $input_data Data
 * @property int $input_required Required
 * @property string $input_validate Validate
 * @property string $input_meta Meta
 * @property int $input_order Order
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
            [['option_name', 'option_value', 'input_label', 'input_hint', 'input_field', 'input_specific', 'input_data', 'input_required', 'input_validate', 'input_meta', 'input_order'], 'required'],
            [['option_value', 'input_hint', 'input_specific', 'input_data', 'input_validate', 'input_meta'], 'string'],
            [['input_required', 'input_order'], 'integer'],
            [['option_name'], 'string', 'max' => 64],
            [['autoload', 'input_field'], 'string', 'max' => 20],
            [['input_label'], 'string', 'max' => 100],
            [['option_name'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'option_id' => Yii::t('core', 'ID'),
            'option_name' => Yii::t('core', 'Name'),
            'option_value' => Yii::t('core', 'Value'),
            'autoload' => Yii::t('core', 'Autoload'),
            'input_label' => Yii::t('core', 'Label'),
            'input_hint' => Yii::t('core', 'Hint'),
            'input_field' => Yii::t('core', 'Field'),
            'input_specific' => Yii::t('core', 'Specific'),
            'input_data' => Yii::t('core', 'Data'),
            'input_required' => Yii::t('core', 'Required'),
            'input_validate' => Yii::t('core', 'Validate'),
            'input_meta' => Yii::t('core', 'Meta'),
            'input_order' => Yii::t('core', 'Order'),
        ];
    }
}
