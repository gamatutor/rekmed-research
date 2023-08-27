<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tindakan_log".
 *
 * @property integer $tindakan_log_id
 * @property integer $tindakan_id
 * @property integer $tarif_dokter
 * @property integer $tarif_asisten
 * @property string $tanggal_perubahan
 *
 * @property Tindakan $tindakan
 */
class TindakanLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tindakan_log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tindakan_id', 'tarif_dokter', 'tarif_asisten'], 'integer'],
            [['tanggal_perubahan'], 'safe'],
            [['tindakan_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tindakan::className(), 'targetAttribute' => ['tindakan_id' => 'tindakan_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'tindakan_log_id' => 'Tindakan Log ID',
            'tindakan_id' => 'Tindakan ID',
            'tarif_dokter' => 'Tarif Dokter',
            'tarif_asisten' => 'Tarif Asisten',
            'tanggal_perubahan' => 'Tanggal Perubahan',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTindakan()
    {
        return $this->hasOne(Tindakan::className(), ['tindakan_id' => 'tindakan_id']);
    }
}
