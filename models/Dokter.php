<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;
use yii\web\FileValidator;

/**
* This is the model class for table "dokter".
 
* @property string $alamat
* @property string $tanggal_lahir
* @property string $created
* @property string $email 
* @property string $alumni 
* @property string $pekerjaan 
* @property string $kota_id 
* @property string $jenis_kelamin 
*
* @property RefKokab $kota 
* @property User $user
* @property Kunjungan[] $kunjungans 
*/
class Dokter extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $imageFile;
    public $username, $password;
    const SCENARIO_PROFILE = 'update';
    public static function tableName()
    {
        return 'dokter';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'nama', 'no_telp', 'spesialis', 'alamat', 'tanggal_lahir', 'email', 'alumni', 'pekerjaan', 'jenis_kelamin'], 'required','on'=>self::SCENARIO_PROFILE],
            [['user_id'], 'integer'],
            [['foto', 'alamat'], 'string'],
            [['tanggal_lahir', 'created'], 'safe'],
            [['nama', 'spesialis', 'email', 'alumni', 'pekerjaan'], 'string', 'max' => 255],
            [['no_telp', 'no_telp_2'], 'string', 'max' => 100],
            [['waktu_praktek'], 'string', 'max' => 500],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['kota_id'], 'string', 'max' => 4], 
            [['kota_id'], 'exist', 'skipOnError' => true, 'targetClass' => RefKokab::className(), 'targetAttribute' => ['kota_id' => 'kota_id']],
           // FILTER NYA disini, tapi error
           //[['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg']
        ];
    }

    //OVERRIDE
    public function delete(){
        $this->user->status = '00';
        return $this->user->save();
    }

    public static function onlyActive()
    {
        return $this->leftJoin('user','user.id=dokter.user_id')->where(['status'=>10]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'nama' => 'Nama Lengkap',
            'no_telp' => 'No Telp',
            'no_telp_2' => 'No Telp 2',
            'spesialis' => 'Spesialis',
            'waktu_praktek' => 'Waktu Praktek',
            'foto' => 'Foto',
            'alamat' => 'Alamat',
            'tanggal_lahir' => 'Tanggal Lahir',
            'created' => 'Created',
            'email' => 'Email', 
            'alumni' => 'Alumni', 
            'pekerjaan' => 'Pekerjaan', 
            'kota_id' => 'Kota/Kabupaten', 
            'jenis_kelamin' => 'Jenis Kelamin', 
            'username' => 'Username', 
            'password' => 'Password', 
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getKota() 
    { 
       return $this->hasOne(RefKokab::className(), ['kota_id' => 'kota_id']); 
    }

    public function getSpesialisasi() 
    { 
       return $this->hasOne(Spesialis::className(), ['spesialis_id' => 'spesialis']); 
    }

    public function upload()
    {
        if ($this->validate()) {
            $src = 'img/dokter/' . $this->user_id;
            //$ext = $this->imageFile->extensions;
            $ext = 'jpg';
            $this->imageFile->saveAs("$src.$ext");
            return true;
        } else {
            return false;
        }
    }

    public function isNothingEmpty()
    {
        $cant_be_empty = ['user_id', 'nama', 'no_telp', 'spesialis', 'alamat', 'tanggal_lahir', 'email', 'alumni', 'pekerjaan', 'jenis_kelamin'];
        $data = self::findOne(Yii::$app->user->identity->id);
        foreach($cant_be_empty as $col)
            if(empty($data->$col)) return false;
        return true;        
    }

    public function getRms()
    {
        return $this->hasMany(RekamMedis::className(), ['user_id' => 'user_id']);

    }
}
