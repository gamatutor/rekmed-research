<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "feedback_reply".
 *
 * @property string $reply_id
 * @property string $feedback_id
 * @property integer $is_admin
 * @property string $isi
 * @property string $created
 *
 * @property Feedback $feedback
 */
class FeedbackReply extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'feedback_reply';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['feedback_id', 'is_admin', 'isi'], 'required'],
            [['feedback_id', 'is_admin'], 'integer'],
            [['isi'], 'string'],
            [['created'], 'safe'],
            [['feedback_id'], 'exist', 'skipOnError' => true, 'targetClass' => Feedback::className(), 'targetAttribute' => ['feedback_id' => 'feedback_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'reply_id' => 'Reply ID',
            'feedback_id' => 'Feedback ID',
            'is_admin' => 'Is Admin',
            'isi' => 'Isi',
            'created' => 'Created',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFeedback()
    {
        return $this->hasOne(Feedback::className(), ['feedback_id' => 'feedback_id']);
    }
}
