<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "berita".
 *
 * @property integer $id
 * @property string $berita
 * @property integer $isactive
 * @property string $created
 */
class Berita extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'berita';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['berita'], 'string'],
            [['isactive'], 'integer'],
            [['created'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'berita' => 'Berita',
            'isactive' => 'Isactive',
            'created' => 'Created',
        ];
    }
}
