<?php

namespace app\models;

use Yii;
use app\models\Klinik;

/**
 * This is the model class for table "rekam_medis".
 *
 * @property string $rm_id
 * @property integer $user_id
 * @property string $kunjungan_id
 * @property string $mr
 * @property string $tekanan_darah
 * @property integer $nadi
 * @property double $respirasi_rate
 * @property double $suhu
 * @property integer $berat_badan
 * @property integer $tinggi_badan
 * @property double $bmi
 * @property string $keluhan_utama
 * @property string $anamnesis
 * @property string $pemeriksaan_fisik
 * @property string $hasil_penunjang
 * @property string $deskripsi_tindakan
 * @property string $saran_pemeriksaan
 * @property string $alergi_obat
 * @property string $created
 * @property string $modified
 *
 * @property Pasien $mr0
 * @property User $user
 * @property Kunjungan $kunjungan
 * @property RmDiagnosis[] $rmDiagnoses
 * @property RmDiagnosisBanding[] $rmDiagnosisBandings
 * @property RmObat[] $rmObats
 * @property RmObatRacik[] $rmObatRaciks
 * @property RmTindakan[] $rmTindakans
 */
class RekamMedis extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $pasien_nama,$tanggal_periksa, $addToTemplate, $templateName, $loadTemplate;
    public $HPL, $mensHariKe, $usiaKehamilan;
    public static function tableName()
    {
        return 'rekam_medis';
    }

    static public function sslEncrypt($string){
        $output = false;
        $encrypt_method = "AES-256-CBC";
        $secret_key = Yii::$app->params['kunciInggris'];
        $secret_iv = Yii::$app->params['kunciSerep'];
        // hash
        $key = hash('sha256', $secret_key);
        
        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hash('sha256', $secret_iv), 0, 16);
        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);
        return $output;
    }

    static public function sslDecrypt($string){
        $output = false;
        $encrypt_method = "AES-256-CBC";
        $secret_key = Yii::$app->params['kunciInggris'];
        $secret_iv = Yii::$app->params['kunciSerep'];
        // hash
        $key = hash('sha256', $secret_key);
        
        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hash('sha256', $secret_iv), 0, 16);
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
        return $output;
    }

    public function encrypt($attr){
        if (isset($this->$attr))
            return RekamMedis::sslEncrypt($this->$attr);
        else return '';
    }   

    public function decrypt($attr){
        if (isset($this->$attr))
            return RekamMedis::sslDecrpt($this->$attr);
        else return '';
    }

    public function decryptDulu(){
        if($this->saran_pemeriksaan!='')
            $this->saran_pemeriksaan = RekamMedis::sslDecrypt($this->saran_pemeriksaan);
        if($this->deskripsi_tindakan!='')
            $this->deskripsi_tindakan = RekamMedis::sslDecrypt($this->deskripsi_tindakan);
        if($this->pemeriksaan_fisik!='')
            $this->pemeriksaan_fisik = RekamMedis::sslDecrypt($this->pemeriksaan_fisik);
        if($this->anamnesis!='')
            $this->anamnesis = RekamMedis::sslDecrypt($this->anamnesis);
        if($this->keluhan_utama!='')
            $this->keluhan_utama = RekamMedis::sslDecrypt($this->keluhan_utama);
        if($this->plan!='')
            $this->plan = RekamMedis::sslDecrypt($this->plan);
        if($this->assesment!='')
            $this->assesment = RekamMedis::sslDecrypt($this->assesment);
    }

    //MODIFY OVERRIDE PARRENT METHOD
    public function save($runValidation = true, $attributeNames = NULL)
    {
        if($this->saran_pemeriksaan!='')
            $this->saran_pemeriksaan = $this->encrypt('saran_pemeriksaan');
        if($this->deskripsi_tindakan!='')
            $this->deskripsi_tindakan = $this->encrypt('deskripsi_tindakan');
        if($this->pemeriksaan_fisik!='')
            $this->pemeriksaan_fisik = $this->encrypt('pemeriksaan_fisik');
        if($this->anamnesis!='')
            $this->anamnesis = $this->encrypt('anamnesis');
        if($this->keluhan_utama!='')
            $this->keluhan_utama = $this->encrypt('keluhan_utama');
        if($this->plan!='')
            $this->plan = $this->encrypt('plan');
        if($this->assesment!='')
            $this->assesment = $this->encrypt('assesment');


        if (Yii::$app->user->identity->spesialis==28)
            $this->spog_hpth = date('Y-m-d', strtotime($this->spog_hpth));
        else
            $this->spog_hpth = null;
        return parent::save($runValidation, $attributeNames);
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mr','user_id', 'kunjungan_id'],'required'],
            [['user_id', 'kunjungan_id', 'nadi', 'tinggi_badan'], 'integer'],
            [['respirasi_rate', 'suhu', 'bmi', 'berat_badan'], 'number'],
            [['keluhan_utama', 'anamnesis', 'pemeriksaan_fisik', 'hasil_penunjang', 'deskripsi_tindakan', 'saran_pemeriksaan','assesment','plan'], 'string'],
            [['created', 'modified','pasien_nama','tanggal_periksa'], 'safe'],
            [['mr'], 'string', 'max' => 25],
            [['tekanan_darah','spog_hpth'], 'string', 'max' => 50],
            [['alergi_obat'], 'string', 'max' => 255],
            [['mr'], 'exist', 'skipOnError' => true, 'targetClass' => Pasien::className(), 'targetAttribute' => ['mr' => 'mr']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['kunjungan_id'], 'exist', 'skipOnError' => true, 'targetClass' => Kunjungan::className(), 'targetAttribute' => ['kunjungan_id' => 'kunjungan_id']],
            [['locked'],'boolean']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'rm_id' => 'Rm ID',
            'pasien_nama' => 'Nama Pasien',
            'user_id' => 'User ID',
            'kunjungan_id' => 'Kunjungan ID',
            'mr' => 'No Rekam Medis',
            'tekanan_darah' => 'TD (mmHg)',
            'nadi' => 'N (x/min)',
            'respirasi_rate' => 'RR (x/min)',
            'suhu' => 'S (C)',
            'berat_badan' => 'BB (kg)',
            'tinggi_badan' => 'TB (cm)',
            'bmi' => 'Bmi',
            'keluhan_utama' => 'Keluhan Utama',
            'anamnesis' => 'S (Subyekif)',
            'pemeriksaan_fisik' => 'O (Obyektif)',
            'hasil_penunjang' => 'Hasil Penunjang (jika ada)',
            'deskripsi_tindakan' => 'Deskripsi Tindakan (jika ada)',
            'saran_pemeriksaan' => 'Rencana Pemeriksaan (jika ada)',
            'alergi_obat' => 'Alergi Obat (jika ada)',
            'created' => 'Tanggal RM',
            'modified' => 'Modified',
            'assesment' => 'A (Assesment)',
            'plan' => 'P (Plan)',
            'templateName' => 'Nama Template',
            'loadTemplate' => 'Load Template',
            'addToTemplate'=>'Tambah ke Daftar Template SOAP?',
            'spog_hpth' => 'HPHT',
            'HPL' => 'HPL',
            'mensHariKe' => 'Mens Hari Ke-',
            'usiaKehamilan' => 'Usia Kehamilan (Minggu Ke-)',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMr0()
    {
        return $this->hasOne(Pasien::className(), ['mr' => 'mr']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKunjungan()
    {
        return $this->hasOne(Kunjungan::className(), ['kunjungan_id' => 'kunjungan_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRmDiagnoses()
    {
        return $this->hasMany(RmDiagnosis::className(), ['rm_id' => 'rm_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRmDiagnosisBandings()
    {
        return $this->hasMany(RmDiagnosisBanding::className(), ['rm_id' => 'rm_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRmObats()
    {
        return $this->hasMany(RmObat::className(), ['rm_id' => 'rm_id']);
    }

    public function getRmObatAnaks()
    {
        return $this->hasMany(RmObatAnak::className(), ['rm_id' => 'rm_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRmObatRaciks()
    {
        return $this->hasMany(RmObatRacik::className(), ['rm_id' => 'rm_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRmTindakans()
    {
        return $this->hasMany(RmTindakan::className(), ['rm_id' => 'rm_id']);
    }

    public function reachMaxRm()
    {
        // $rm_count = $this->find()->joinWith('kunjungan')->where(['klinik_id'=>Yii::$app->user->identity->klinik_id])->count();
        $rm_count = $this->find()->joinWith('kunjungan')->groupBy(['kunjungan_id'])->where(['kunjungan.klinik_id'=>Yii::$app->user->identity->klinik_id])->count();
        $klinik = Klinik::findOne(Yii::$app->user->identity->klinik_id);

        if($rm_count<=$klinik->maximum_row){
            return false;
        }
        return true;
    }

    public function getBelongsToDr($id = null)
    {
        if($id==null)
            $id = Yii::$app->user->identity->id;

        return $this->kunjungan->dokter_periksa == $id;
    }

    public function getBelongsToKlinik($id = null)
    {
        if($id==null)
            $id = Yii::$app->user->identity->klinik_id;

        return $this->kunjungan->klinik_id == $id;
    }

    public function delRelationship()
    {
        \app\models\RmDiagnosis::deleteAll('rm_id = :rm',[':rm'=>$this->rm_id]);
        \app\models\RmDiagnosisBanding::deleteAll('rm_id = :rm',[':rm'=>$this->rm_id]);
        \app\models\RmObat::deleteAll('rm_id = :rm',[':rm'=>$this->rm_id]);
        \app\models\RmObatAnak::deleteAll('rm_id = :rm',[':rm'=>$this->rm_id]);
        \app\models\RmObatRacik::deleteAll('rm_id = :rm',[':rm'=>$this->rm_id]);
        \app\models\RmTindakan::deleteAll('rm_id = :rm',[':rm'=>$this->rm_id]);
        $this->delete();
    }
}
