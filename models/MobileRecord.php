<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mobile_record".
 *
 * @property string $id
 * @property integer $user_id
 * @property string $title
 * @property string $content
 * @property string $attachment
 * @property string $filetype
 * @property string $mr
 * @property string $created_at
 * @property string $updated_at
 */
class MobileRecord extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */

    public $apiStorageUrl = 'http://api.rekmed.com/uploads/';
    public static function tableName()
    {
        return 'mobile_record';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'integer'],
            [['title', 'content', 'attachment'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['filetype'], 'string', 'max' => 5],
            [['mr'], 'string', 'max' => 25],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'title' => 'Title',
            'content' => 'Content',
            'attachment' => 'Attachment',
            'filetype' => 'Filetype',
            'mr' => 'Mr',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
