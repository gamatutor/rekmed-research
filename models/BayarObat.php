<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "bayar_obat".
 *
 * @property string $bayar_obat_id
 * @property string $no_invoice
 * @property integer $obat_id
 * @property string $nama_obat
 * @property integer $jumlah
 * @property integer $harga_satuan
 * @property integer $harga_total
 * @property integer $is_racik
 *
 * @property Obat $obat
 * @property Bayar $noInvoice
 */
class BayarObat extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'bayar_obat';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['obat_id', 'jumlah', 'harga_satuan', 'harga_total', 'is_racik'], 'integer'],
            [['no_invoice'], 'string', 'max' => 20],
            [['nama_obat'], 'string', 'max' => 255],
            [['obat_id'], 'exist', 'skipOnError' => true, 'targetClass' => Obat::className(), 'targetAttribute' => ['obat_id' => 'obat_id']],
            [['no_invoice'], 'exist', 'skipOnError' => true, 'targetClass' => Bayar::className(), 'targetAttribute' => ['no_invoice' => 'no_invoice']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'bayar_obat_id' => 'Bayar Obat ID',
            'no_invoice' => 'No Invoice',
            'obat_id' => 'Obat ID',
            'nama_obat' => 'Nama Obat',
            'jumlah' => 'Jumlah',
            'harga_satuan' => 'Harga Satuan',
            'harga_total' => 'Harga Total',
            'is_racik' => 'Is Racik',
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
    public function getNoInvoice()
    {
        return $this->hasOne(Bayar::className(), ['no_invoice' => 'no_invoice']);
    }
}
