<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "feedback".
 *
 * @property string $feedback_id
 * @property integer $user_id
 * @property string $kategori
 * @property string $isi
 * @property integer $is_new
 * @property string $created
 *
 * @property User $user
 * @property FeedbackReply[] $feedbackReplies
 */
class Feedback extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'feedback';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'isi'], 'required'],
            [['user_id', 'is_new'], 'integer'],
            [['kategori', 'isi'], 'string'],
            [['created'], 'safe'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'feedback_id' => 'Feedback ID',
            'user_id' => 'Pengguna',
            'kategori' => 'Kategori',
            'isi' => 'Isi',
            'is_new' => 'Is New',
            'created' => 'Tanggal',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFeedbackReplies()
    {
        return $this->hasMany(FeedbackReply::className(), ['feedback_id' => 'feedback_id']);
    }
}
