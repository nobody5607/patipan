<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "test_choice".
 *
 * @property int $id
 * @property int $test_id
 * @property string $num1 คำตอบ
 * @property string $label หัวข้อคำตอบ
 * @property int $create_at สร้างโดย
 * @property string $create_date สร้างเมื่อ
 */
class TestChoice extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'test_choice';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['label', 'value'], 'required'], 
            [['test_id', 'create_at'], 'integer'], 
            [['create_date','value'], 'safe'],
            [['label'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'test_id' => Yii::t('app', 'รหัสคำถาม'),
            'label' => Yii::t('app', 'หัวข้อคำตอบ'),
            'value' => Yii::t('app', 'คำตอบ'),
            'create_at' => Yii::t('app', 'สร้างโดย'),
            'create_date' => Yii::t('app', 'สร้างเมื่อ'),
        ];
    }
}
