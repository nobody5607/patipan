<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "lessons".
 *
 * @property int $id
 * @property string $name บทที่
 * @property string $detail เนื้อหา
 * @property int $section ชั้น
 * @property int $create_by สร้างโดย
 * @property string $create_date สร้างเมื่อ
 * @property int $update_by แก้ไขโดย
 * @property string $update_date แก้ไขเมื่อ
 * @property int $rstat สถานะ
 * @property int $forder เรียงลำดับ
 */
class Lessons extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lessons';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['detail','section','name'], 'required'],
            [['detail'], 'string'],
            [['section', 'create_by', 'update_by', 'rstat', 'forder'], 'integer'],
            [['create_date', 'update_date'], 'safe'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'บทที่'),
            'detail' => Yii::t('app', 'เนื้อหา'),
            'section' => Yii::t('app', 'ชั้น'),
            'create_by' => Yii::t('app', 'สร้างโดย'),
            'create_date' => Yii::t('app', 'สร้างเมื่อ'),
            'update_by' => Yii::t('app', 'แก้ไขโดย'),
            'update_date' => Yii::t('app', 'แก้ไขเมื่อ'),
            'rstat' => Yii::t('app', 'สถานะ'),
            'forder' => Yii::t('app', 'เรียงลำดับ'),
        ];
    }
}
