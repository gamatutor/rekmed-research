<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "rm_obat_anak".
 *
 * @property integer $id
 * @property string $rm_id
 * @property integer $obat_id
 * @property string $nama_obat
 * @property string $dosis
 * @property string $kemasan
 * @property integer $jumlah
 * @property string $created
 *
 * @property RekamMedis $rm
 * @property Obat $obat
 */
class RmObatAnak extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rm_obat_anak';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['rm_id', 'obat_id', 'jumlah'], 'integer'],
            [['created', 'dosis', 'kemasan'], 'safe'],
            [['nama_obat'], 'string', 'max' => 255],
            [['rm_id'], 'exist', 'skipOnError' => true, 'targetClass' => RekamMedis::className(), 'targetAttribute' => ['rm_id' => 'rm_id']],
            [['obat_id'], 'exist', 'skipOnError' => true, 'targetClass' => Obat::className(), 'targetAttribute' => ['obat_id' => 'obat_id']],
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
            'dosis' => 'Dosis(mg/kgbb)',
            'kemasan' => 'Kemasan(mg/tablet)',
            'jumlah' => 'Jumlah',
            'created' => 'Created',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRm()
    {
        return $this->hasOne(RekamMedis::className(), ['rm_id' => 'rm_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getObat()
    {
        return $this->hasOne(Obat::className(), ['obat_id' => 'obat_id']);
    }
}
