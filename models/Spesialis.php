<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "spesialis".
 *
 * @property integer $spesialis_id
 * @property string $nama
 */
class Spesialis extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'spesialis';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['spesialis_id'], 'required'],
            [['spesialis_id'], 'integer'],
            [['nama'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'spesialis_id' => 'Spesialis ID',
            'nama' => 'Spesialis',
        ];
    }
}
