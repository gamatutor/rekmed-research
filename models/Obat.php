<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "obat".
 *
 * @property integer $obat_id
 * @property integer $klinik_id
 * @property string $nama_merk
 * @property string $pabrikan
 * @property string $spesifikasi
 * @property string $nama_generik
 * @property string $golongan
 * @property string $tanggal_beli
 * @property string $tanggal_kadaluarsa
 * @property integer $harga_beli
 * @property integer $harga_jual
 * @property integer $stok
 * @property string $created
 * @property string $modified
 *
 * @property BayarObat[] $bayarObats
 * @property Klinik $klinik
 * @property RmObat[] $rmObats
 * @property RmObatRacikKomponen[] $rmObatRacikKomponens
 * @property StokObat[] $stokObats
 */
class Obat extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'obat';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['harga_beli','harga_jual','nama_merk','nama_generik','golongan','dosis','kemasan'],'required'],
            [['klinik_id', 'harga_beli', 'harga_jual', 'stok'], 'integer'],
            [['spesifikasi'], 'string'],
            [['tanggal_beli', 'tanggal_kadaluarsa', 'created', 'modified','dosis','kemasan'], 'safe'],
            [['nama_merk', 'pabrikan', 'golongan'], 'string', 'max' => 255],
            [['nama_generik'], 'string', 'max' => 500],
            [['klinik_id'], 'exist', 'skipOnError' => true, 'targetClass' => Klinik::className(), 'targetAttribute' => ['klinik_id' => 'klinik_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'obat_id' => 'Obat ID',
            'klinik_id' => 'Klinik ID',
            'nama_merk' => 'Nama Merk',
            'pabrikan' => 'Pabrikan',
            'spesifikasi' => 'Spesifikasi',
            'nama_generik' => 'Nama Generik',
            'golongan' => 'Golongan',
            'dosis' => 'Dosis(mg/kgbb)',
            'kemasan' => 'Kemasan(mg/tablet)',
            'tanggal_beli' => 'Tanggal Beli',
            'tanggal_kadaluarsa' => 'Tanggal Kadaluarsa',
            'harga_beli' => 'Harga Beli',
            'harga_jual' => 'Harga Jual',
            'stok' => 'Stok',
            'created' => 'Created',
            'modified' => 'Modified',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBayarObats()
    {
        return $this->hasMany(BayarObat::className(), ['obat_id' => 'obat_id']);
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
    public function getRmObats()
    {
        return $this->hasMany(RmObat::className(), ['obat_id' => 'obat_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRmObatRacikKomponens()
    {
        return $this->hasMany(RmObatRacikKomponen::className(), ['obat_id' => 'obat_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStokObats()
    {
        return $this->hasMany(StokObat::className(), ['obat_id' => 'obat_id']);
    }
}
