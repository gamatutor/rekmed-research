<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tindakan".
 *
 * @property integer $tindakan_id
 * @property integer $klinik_id
 * @property string $nama_tindakan
 * @property integer $tarif_dokter
 * @property integer $tarif_asisten
 * @property string $created
 * @property string $modified
 *
 * @property BayarTindakan[] $bayarTindakans
 * @property RmTindakan[] $rmTindakans
 * @property Klinik $klinik
 * @property TindakanLog[] $tindakanLogs
 */
class Tindakan extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tindakan';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['klinik_id', 'tarif_dokter', 'tarif_asisten'], 'integer'],
            [['created', 'modified'], 'safe'],
            [['nama_tindakan'], 'string', 'max' => 500],
            [['klinik_id'], 'exist', 'skipOnError' => true, 'targetClass' => Klinik::className(), 'targetAttribute' => ['klinik_id' => 'klinik_id']],
            [['biaya_wajib'],'boolean']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'tindakan_id' => 'Tindakan ID',
            'klinik_id' => 'Klinik ID',
            'nama_tindakan' => 'Nama Tindakan',
            'tarif_dokter' => 'Tarif Dokter',
            'tarif_asisten' => 'Tarif Asisten',
            'created' => 'Created',
            'modified' => 'Modified',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBayarTindakans()
    {
        return $this->hasMany(BayarTindakan::className(), ['tindakan_id' => 'tindakan_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRmTindakans()
    {
        return $this->hasMany(RmTindakan::className(), ['tindakan_id' => 'tindakan_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKlinik()
    {
        return $this->hasOne(Klinik::className(), ['klinik_id' => 'klinik_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTindakanLogs()
    {
        return $this->hasMany(TindakanLog::className(), ['tindakan_id' => 'tindakan_id']);
    }
}
