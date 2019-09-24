<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "players".
 *
 * @property int $id
 * @property string $games
 * @property int $times
 * @property int $scores
 * @property int $type
 * @property int $user_id
 * @property int $index
 */
class Players extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'players';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['times', 'scores', 'type', 'user_id', 'index'], 'integer'],
            [['games'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'games' => Yii::t('app', 'Games'),
            'times' => Yii::t('app', 'Times'),
            'scores' => Yii::t('app', 'Scores'),
            'type' => Yii::t('app', 'Type'),
            'user_id' => Yii::t('app', 'User ID'),
            'index' => Yii::t('app', 'Index'),
        ];
    }
}
