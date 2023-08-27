<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ref_provinsi".
 *
 * @property string $provinsi_id
 * @property string $provinsi_nama
 *
 * @property RefKokab[] $refKokabs
 */
class RefProvinsi extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ref_provinsi';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['provinsi_id'], 'required'],
            [['provinsi_id'], 'string', 'max' => 2],
            [['provinsi_nama'], 'string', 'max' => 30],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'provinsi_id' => 'Provinsi ID',
            'provinsi_nama' => 'Provinsi Nama',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRefKokabs()
    {
        return $this->hasMany(RefKokab::className(), ['provinsi_id' => 'provinsi_id']);
    }
}
