<?php

namespace backend\modules\core\models;
use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\AttributeBehavior;
use appxq\sdii\behaviors\SDMultiValueBehavior;
use appxq\sdii\utils\SDUtility;

/**
 * This is the model class for table "core_fields".
 *
 * @property string $field_code Code
 * @property int $field_internal Internal
 * @property string $field_class Class
 * @property string $field_name Function
 * @property string $field_meta Option
 * @property string $field_description Description
 */
class CoreFields extends \yii\db\ActiveRecord
{
    public function behaviors() {
		return [
			[
				'class' => AttributeBehavior::className(),
				'attributes' => [
					ActiveRecord::EVENT_INIT => 'field_internal',
				],
				'value' => function ($event) {
					return 1;
				},
			],
			[
				'class' => SDMultiValueBehavior::className(),
				'attributes' => [
					ActiveRecord::EVENT_AFTER_FIND => 'field_meta',
				],
				'value' => function ($event) {
					return SDUtility::string2strArray($event->sender[$event->data]);
				},
			],
			[
				'class' => SDMultiValueBehavior::className(),
				'attributes' => [
					ActiveRecord::EVENT_BEFORE_INSERT => 'field_meta',
					ActiveRecord::EVENT_BEFORE_UPDATE => 'field_meta',
				],
				'value' => function ($event) {
					return SDUtility::strArray2String($event->sender[$event->data]);
				},
			],
		];
	}
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'core_fields';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['field_code', 'field_class', 'field_name', 'field_meta', 'field_description'], 'required'],
            [['field_internal'], 'integer'],
            [['field_meta', 'field_description'], 'string'],
            [['field_code'], 'string', 'max' => 20],
            [['field_class'], 'string', 'max' => 80],
            [['field_name'], 'string', 'max' => 30],
            [['field_code'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'field_code' => Yii::t('core', 'Code'),
            'field_internal' => Yii::t('core', 'Internal'),
            'field_class' => Yii::t('core', 'Class'),
            'field_name' => Yii::t('core', 'Function'),
            'field_meta' => Yii::t('core', 'Option'),
            'field_description' => Yii::t('core', 'Description'),
        ];
    }
}
