<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "bayar_tindakan".
 *
 * @property string $bayar_tindakan_id
 * @property string $no_invoice
 * @property integer $tindakan_id
 * @property string $nama_tindakan
 * @property string $harga
 *
 * @property Bayar $noInvoice
 * @property Tindakan $tindakan
 */
class BayarTindakan extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'bayar_tindakan';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tindakan_id', 'harga'], 'integer'],
            [['no_invoice'], 'string', 'max' => 20],
            [['nama_tindakan'], 'string', 'max' => 255],
            [['no_invoice'], 'exist', 'skipOnError' => true, 'targetClass' => Bayar::className(), 'targetAttribute' => ['no_invoice' => 'no_invoice']],
            [['tindakan_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tindakan::className(), 'targetAttribute' => ['tindakan_id' => 'tindakan_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'bayar_tindakan_id' => 'Bayar Tindakan ID',
            'no_invoice' => 'No Invoice',
            'tindakan_id' => 'Tindakan ID',
            'nama_tindakan' => 'Nama Tindakan',
            'harga' => 'Harga',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNoInvoice()
    {
        return $this->hasOne(Bayar::className(), ['no_invoice' => 'no_invoice']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTindakan()
    {
        return $this->hasOne(Tindakan::className(), ['tindakan_id' => 'tindakan_id']);
    }
}
