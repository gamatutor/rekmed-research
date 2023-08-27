<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "rm_obat".
 *
 * @property string $id
 * @property string $rm_id
 * @property integer $obat_id
 * @property string $nama_obat
 * @property double $jumlah
 * @property string $signa
 *
 * @property Obat $obat
 * @property RekamMedis $rm
 */
class RmObat extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rm_obat';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['rm_id', 'obat_id'], 'integer'],
            [['jumlah'], 'number'],
            [['nama_obat', 'signa'], 'string', 'max' => 255],
            [['obat_id'], 'exist', 'skipOnError' => true, 'targetClass' => Obat::className(), 'targetAttribute' => ['obat_id' => 'obat_id']],
            [['rm_id'], 'exist', 'skipOnError' => true, 'targetClass' => RekamMedis::className(), 'targetAttribute' => ['rm_id' => 'rm_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'rm_id' => 'Rm ID',
            'obat_id' => 'Obat ID',
            'nama_obat' => 'Nama Obat',
            'jumlah' => 'Jumlah',
            'signa' => 'Signa',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getObat()
    {
        return $this->hasOne(Obat::className(), ['obat_id' => 'obat_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRm()
    {
        return $this->hasOne(RekamMedis::className(), ['rm_id' => 'rm_id']);
    }
}
