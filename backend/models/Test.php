<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "test".
 *
 * @property int $id
 * @property int $number ลำดับ
 * @property string $question คำถาม
 * @property string $answer คำตอบที่ถูกต้อง
 * @property int $create_by สร้างโดย
 * @property string $create_date สร้างเมื่อ
 * @property int $update_by แก้ไขโดย
 * @property string $update_date แก้ไขเมื่อ
 */
class Test extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'test';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['number','question','answer','type'], 'required'],
            [['number', 'create_by', 'update_by'], 'integer'],
            [['create_date', 'update_date','type'], 'safe'],
            [['question'], 'string', 'max' => 255],
            [['answer'], 'string', 'max' => 5],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'number' => Yii::t('app', 'ลำดับ'),
            'question' => Yii::t('app', 'คำถาม'),
            'answer' => Yii::t('app', 'เฉลย'),
            'create_by' => Yii::t('app', 'สร้างโดย'),
            'create_date' => Yii::t('app', 'สร้างเมื่อ'),
            'update_by' => Yii::t('app', 'แก้ไขโดย'),
            'update_date' => Yii::t('app', 'แก้ไขเมื่อ'),
            'type'=>'ประเภทก่อนหรือหลังเรียน'
        ];
    }
}
