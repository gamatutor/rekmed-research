<?php

namespace app\models;
use app\models\Obat;

use Yii;

/**
 * This is the model class for table "stok_obat".
 *
 * @property string $stok_id
 * @property integer $obat_id
 * @property string $tanggal_stok
 * @property string $tipe
 * @property string $jenis
 * @property string $keterangan
 * @property integer $jumlah
 * @property integer $stok_sebelum
 *
 * @property Obat $obat
 */
class StokObat extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'stok_obat';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['obat_id', 'jumlah', 'stok_sebelum'], 'integer'],
            [['tanggal_stok'], 'safe'],
            [['tipe', 'jenis', 'keterangan'], 'string'],
            [['obat_id'], 'exist', 'skipOnError' => true, 'targetClass' => Obat::className(), 'targetAttribute' => ['obat_id' => 'obat_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'stok_id' => 'Stok ID',
            'obat_id' => 'Obat ID',
            'tanggal_stok' => 'Tanggal Stok',
            'tipe' => 'Tipe',
            'jenis' => 'Jenis',
            'keterangan' => 'Keterangan',
            'jumlah' => 'Jumlah',
            'stok_sebelum' => 'Stok Sebelum',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getObat()
    {
        return $this->hasOne(Obat::className(), ['obat_id' => 'obat_id']);
    }

    public function ubahStok($obat_id,$tipe,$jenis,$keterangan,$jumlah)
    {
        $model = Obat::findOne($obat_id);
        $stok_sebelum = $model->stok;
        if($tipe=='tambah') $model->stok += $jumlah;
        if($tipe=='kurang') $model->stok -= $jumlah;
        $model->save();

        $stok = new StokObat();
        $stok->obat_id = $obat_id;
        $stok->tanggal_stok = date('Y-m-d H:i:s');
        $stok->tipe = $tipe;
        $stok->jenis = $jenis;
        $stok->keterangan = $keterangan;
        $stok->jumlah = $jumlah;
        $stok->stok_sebelum = $stok_sebelum;
        $stok->save();
    }
}
