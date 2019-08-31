<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "informations".
 *
 * @property int $id ID
 * @property string $title ไตเติ้ล
 * @property string $detail รายละเอียด
 * @property string $image รูปขนาดย่อย
 * @property int $rstat สถานะ
 * @property int $create_by สร้างโดย
 * @property string $create_date สร้างเมื่อ
 * @property int $update_by แก้ไขโดย
 * @property string $update_date แก้ไขเมื่อ
 */
class Informations extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'informations';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'rstat', 'create_by', 'update_by'], 'integer'],
            [['create_date', 'update_date'], 'safe'],
            [['title', 'detail', 'image'], 'string', 'max' => 255],
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
            'title' => Yii::t('app', 'ไตเติ้ล'),
            'detail' => Yii::t('app', 'รายละเอียด'),
            'image' => Yii::t('app', 'รูปขนาดย่อย'),
            'rstat' => Yii::t('app', 'สถานะ'),
            'create_by' => Yii::t('app', 'สร้างโดย'),
            'create_date' => Yii::t('app', 'สร้างเมื่อ'),
            'update_by' => Yii::t('app', 'แก้ไขโดย'),
            'update_date' => Yii::t('app', 'แก้ไขเมื่อ'),
        ];
    }
}
