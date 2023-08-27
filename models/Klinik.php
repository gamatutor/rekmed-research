<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "klinik".
 *
 * @property integer $klinik_id
 * @property string $klinik_nama
 * @property string $alamat
 * @property string $nomor_telp_1
 * @property string $nomor_telp_2
 * @property string $kepala_klinik
 * @property string $maximum_row
 *
 * @property KlinikCredit[] $klinikCredits
 * @property Kunjungan[] $kunjungans
 * @property Obat[] $obats
 * @property Pasien[] $pasiens
 * @property Tindakan[] $tindakans
 * @property User[] $users
 */
class Klinik extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'klinik';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['alamat'], 'string'],
            [['maximum_row'], 'integer'],
            [['klinik_nama', 'kepala_klinik'], 'string', 'max' => 255],
            [['nomor_telp_1', 'nomor_telp_2'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'klinik_id' => 'Klinik ID',
            'klinik_nama' => 'Nama Klinik',
            'alamat' => 'Alamat',
            'nomor_telp_1' => 'Nomor Telp 1',
            'nomor_telp_2' => 'Nomor Telp 2',
            'kepala_klinik' => 'Kepala Klinik',
            'maximum_row' => 'Maks. RM Saat Ini',
            'rmSekarang' => 'Penggunaan RM Saat Ini',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKlinikCredits()
    {
        return $this->hasMany(KlinikCredit::className(), ['klinik_id' => 'klinik_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKunjungans()
    {
        return $this->hasMany(Kunjungan::className(), ['klinik_id' => 'klinik_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getObats()
    {
        return $this->hasMany(Obat::className(), ['klinik_id' => 'klinik_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPasiens()
    {
        return $this->hasMany(Pasien::className(), ['klinik_id' => 'klinik_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTindakans()
    {
        return $this->hasMany(Tindakan::className(), ['klinik_id' => 'klinik_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['klinik_id' => 'klinik_id']);
    }

    public function getRmSekarang()
    {
        return RekamMedis::find()->leftJoin('kunjungan','kunjungan.kunjungan_id = rekam_medis.kunjungan_id')->where(['klinik_id'=>$this->klinik_id])->count();
    }

    public function clearRM()
    {
        $kunjungan_id = array_column(\app\models\Kunjungan::find()->select('kunjungan_id')->where(['klinik_id'=>$this->klinik_id])->asArray()->all(),'kunjungan_id');

        $rm_id = array_column(\app\models\RekamMedis::find()->select('rm_id')->where(['IN','kunjungan_id',$kunjungan_id])->asArray()->all(),'rm_id');
        $racik_id = array_column(\app\models\RmObatRacik::find()->select('racik_id')->where(['IN','rm_id',$rm_id])->asArray()->all(),'racik_id');

        \app\models\RmDiagnosis::deleteAll(['IN','rm_id',$rm_id]);
        \app\models\RmObat::deleteAll(['IN','rm_id',$rm_id]);
        \app\models\RmDiagnosisBanding::deleteAll(['IN','rm_id',$rm_id]);
        \app\models\RmTindakan::deleteAll(['IN','rm_id',$rm_id]);
        \app\models\RmPenunjang::deleteAll(['IN','rm_id',$rm_id]);
        \app\models\RmObatRacikKomponen::deleteAll(['IN','racik_id',$racik_id]);
        \app\models\RmObatRacik::deleteAll(['IN','rm_id',$rm_id]);


        \app\models\Kunjungan::deleteAll(['IN','kunjungan_id',$kunjungan_id]);
        \app\models\RekamMedis::deleteAll(['IN','rm_id',$rm_id]);
        
        return true;
    }
}
