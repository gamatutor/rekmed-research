<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "kunjungan".
 *
 * @property string $kunjungan_id
 * @property integer $klinik_id
 * @property string $mr
 * @property string $tanggal_periksa
 * @property string $jam_masuk
 * @property string $jam_selesai
 * @property string $status
 * @property string $created
 * @property string $user_input
 * @property integer $user_id
 *
 * @property Klinik $klinik
 * @property Pasien $mr0
 * @property User $user
 * @property RekamMedis[] $rekamMedis
 */
class Kunjungan extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $pasien_nama;
    
    public static function tableName()
    {
        return 'kunjungan';
    }

    static public function hitAntrian($klinik_id, $date = '')
    {
        if($date == '')
            $date = date('Y-m-d');

        return Kunjungan::find()
            ->where(['klinik_id'=>$klinik_id, 'tanggal_periksa'=>$date])
            ->count()+1;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['klinik_id', 'user_id','dokter_periksa','nomor_antrian'], 'integer'],
            [['tanggal_periksa', 'jam_masuk', 'jam_selesai', 'created','pasien_nama'], 'safe'],
            [['status'], 'string'],
            [['mr'], 'string', 'max' => 25],
            [['user_input'], 'string', 'max' => 100],
            [['klinik_id'], 'exist', 'skipOnError' => true, 'targetClass' => Klinik::className(), 'targetAttribute' => ['klinik_id' => 'klinik_id']],
            [['mr'], 'exist', 'skipOnError' => true, 'targetClass' => Pasien::className(), 'targetAttribute' => ['mr' => 'mr']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'kunjungan_id' => 'Kunjungan ID',
            'pasien_nama' => 'Nama Pasien',
            'klinik_id' => 'Klinik ID',
            'mr' => 'No Rekam Medis',
            'tanggal_periksa' => 'Tanggal Periksa',
            'jam_masuk' => 'Jam Masuk',
            'jam_selesai' => 'Jam Selesai',
            'status' => 'Status',
            'created' => 'Created',
            'user_input' => 'User Input',
            'user_id' => 'User ID',
            'dokter_periksa' => 'Dokter',
        ];
    }

    public function getKunjunganSebelumnya()
    {
        return Kunjungan::find()->where(['<','kunjungan_id',$this->kunjungan_id])->andWhere(['mr'=>$this->mr])->orderBy(['kunjungan_id'=>SORT_DESC])->limit(1)->one();
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
    public function getDokter0()
    {
        return $this->hasOne(Dokter::className(), ['user_id' => 'dokter_periksa']);
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
    public function getRekamMedis()
    {
        return $this->hasMany(RekamMedis::className(), ['kunjungan_id' => 'kunjungan_id']);
    }

    /** 
    * @return \yii\db\ActiveQuery 
    */ 
   public function getBayar() 
   { 
       return $this->hasMany(Bayar::className(), ['kunjungan_id' => 'kunjungan_id']); 
   }

   public static function getSisaRm(){
        $klinik_id = Yii::$app->user->identity->klinik_id;
        $N = Kunjungan::find()->where(['klinik_id'=>$klinik_id])->count();
        $max = \app\models\Klinik::findOne($klinik_id)->maximum_row;
        return $max - $N;
   }

   public static function getNRmNow(){
        $klinik_id = Yii::$app->user->identity->klinik_id;
        return Kunjungan::find()->where(['klinik_id'=>$klinik_id])->count();
   }

   public function getBelongsToDr($id = null)
   {
        if($id==null)
            $id = Yii::$app->user->identity->id;
        
        if($this->dokter_periksa == null)
            return $this->belongsToKlinik;

        return $this->dokter_periksa == $id;
   }

   public function getBelongsToKlinik($id = null)
   {
        if($id==null)
            $id = Yii::$app->user->identity->klinik_id;

        return $this->klinik_id == $id;
   }
}
