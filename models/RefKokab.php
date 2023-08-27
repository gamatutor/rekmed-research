<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ref_kokab".
 *
 * @property string $kota_id
 * @property string $kokab_nama
 * @property string $provinsi_id
 *
 * @property Dokter[] $dokters
 * @property RefProvinsi $provinsi
 */
class RefKokab extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ref_kokab';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['kota_id'], 'required'],
            [['kota_id'], 'string', 'max' => 4],
            [['kokab_nama'], 'string', 'max' => 30],
            [['provinsi_id'], 'string', 'max' => 2],
            [['provinsi_id'], 'exist', 'skipOnError' => true, 'targetClass' => RefProvinsi::className(), 'targetAttribute' => ['provinsi_id' => 'provinsi_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'kota_id' => 'Kota ID',
            'kokab_nama' => 'Kokab Nama',
            'provinsi_id' => 'Provinsi ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDokters()
    {
        return $this->hasMany(Dokter::className(), ['kota_id' => 'kota_id'])->leftJoin('user','user.id=dokter.user_id')->where(['user.status'=>10]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProvinsi()
    {
        return $this->hasOne(RefProvinsi::className(), ['provinsi_id' => 'provinsi_id']);
    }
}
