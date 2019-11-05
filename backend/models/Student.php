<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "student".
 *
 * @property string $id รหัสประจำตัวนักเรียน
 * @property string $name ชื่อนักเรียน
 * @property int $number เลขที่
 * @property string $room ห้อง
 * @property int $sex เพศ
 * @property string $address ที่อยู่
 * @property string $tel เบอร์โทร
 * @property int $create_by สร้างโดย
 * @property string $create_date สร้างเมื่อ
 * @property int $update_by แก้ไขโดย
 * @property string $update_date แก้ไขเมื่อ
 * @property int $rstat สถานะ
 */
class Student extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'student';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id','password','name','sex','tel','number'], 'required'],
            [['number', 'sex', 'create_by', 'update_by', 'rstat'], 'integer'],
            [['address'], 'string'],
            [['create_date', 'update_date','token','start_score','end_score','image','address'], 'safe'],
            [['name'], 'string', 'max' => 200],
            [['room'], 'string', 'max' => 10],
            [['id'], 'string', 'max' => 20],
            [['id','number'], 'unique'],
            ['tel', 'string', 'min' => 10, 'max' => 10,'message'=>'เบอร์โทรศัพทต้องมี 10 ตัว']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'เลขประจำตัว'),
            'name' => Yii::t('app', 'ชื่อนักเรียน'),
            'number' => Yii::t('app', 'เลขที่'),
            'room' => Yii::t('app', 'ห้อง'),
            'sex' => Yii::t('app', 'เพศ'),
            'address' => Yii::t('app', 'ที่อยู่'),
            'tel' => Yii::t('app', 'เบอร์โทร'),
            'create_by' => Yii::t('app', 'สร้างโดย'),
            'create_date' => Yii::t('app', 'สร้างเมื่อ'),
            'update_by' => Yii::t('app', 'แก้ไขโดย'),
            'update_date' => Yii::t('app', 'แก้ไขเมื่อ'),
            'rstat' => Yii::t('app', 'สถานะ'),
            
        ];
    }
}
