<?php

namespace app\models;
use yii\web\UploadedFile;

use Yii;

/**
 * This is the model class for table "pasien".
 *
 * @property string $mr
 * @property integer $klinik_id
 * @property string $nama
 * @property string $tanggal_lahir
 * @property string $jk
 * @property string $alamat
 * @property string $no_telp
 * @property string $pekerjaan
 * @property string $penanggung_jawab
 * @property string $created
 * @property string $modified
 * @property string $user_input
 * @property string $user_modified
 *
 * @property Kunjungan[] $kunjungans
 * @property Klinik $klinik
 * @property RekamMedis[] $rekamMedis
 */
class Pasien extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $imageFile;
    public static function tableName()
    {
        return 'pasien';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mr','klinik_id','tanggal_lahir','jk','nama'], 'required'],
            [['klinik_id'], 'integer'],
            [['email'], 'email'],
            [['tanggal_lahir', 'created', 'modified'], 'safe'],
            [['jk', 'alamat','foto','no_nik','alergi'], 'string'],
            [['mr'], 'string', 'max' => 25],
            [['mr'], 'unique'],
            [['nama'], 'string', 'max' => 255],
            [['no_telp'], 'string', 'max' => 50],
            [['no_nik'], 'string', 'max' => 25],
            [['pekerjaan', 'penanggung_jawab', 'user_input', 'user_modified'], 'string', 'max' => 100],
            [['klinik_id'], 'exist', 'skipOnError' => true, 'targetClass' => Klinik::className(), 'targetAttribute' => ['klinik_id' => 'klinik_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'mr' => 'No Rekam Medis',
            'klinik_id' => 'Klinik ID',
            'nama' => 'Nama',
            'tanggal_lahir' => 'Tanggal Lahir',
            'jk' => 'Jenis Kelamin',
            'alamat' => 'Alamat',
            'no_telp' => 'No Telp',
            'pekerjaan' => 'Pekerjaan',
            'penanggung_jawab' => 'Penanggung Jawab',
            'created' => 'Created',
            'modified' => 'Modified',
            'user_input' => 'User Input',
            'user_modified' => 'User Modified',
            'imageFile' => 'Foto',
            'no_nik' => 'No. NIK'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKunjungans()
    {
        return $this->hasMany(Kunjungan::className(), ['mr' => 'mr']);
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
    public function getRekamMedis()
    {
        return $this->hasMany(RekamMedis::className(), ['mr' => 'mr']);
    }

    public function upload()
    {
        if ($this->validate()) {
            $src = 'img/pasien/' . $this->mr;
            $ext = $this->imageFile->extension;
            $this->imageFile->saveAs("$src.$ext");

            return true;
        } else {
            return false;
        }
    }

    public function getAge($birthDate)
    {
        $birthDate = explode("-", $birthDate);
        $age = (date("md", date("U", mktime(0, 0, 0, $birthDate[1], $birthDate[2], $birthDate[0]))) > date("md")
          ? ((date("Y") - $birthDate[0]) - 1)
          : (date("Y") - $birthDate[0]));
        return $age;
    }

    public function createMr()
    {
        $connection = Yii::$app->db;
        $klinik_id = Yii::$app->user->identity->klinik_id;
        $sql = "SELECT 
                  LPAD(
                    IFNULL(
                      MAX(
                        CONVERT(SUBSTR(mr, -6), UNSIGNED INTEGER)
                      ),
                      0
                    ) + 1,
                    6,
                    0
                  ) AS NEXT_MR 
                FROM
                  pasien 
                WHERE klinik_id = $klinik_id ";
        $command = $connection->createCommand($sql);
        $nextmr = $command->queryOne();
        return $klinik_id.$nextmr['NEXT_MR'];
    }

    public function getNextVisit(){
        $mdl = PasienNextVisit::find()->where(['mr'=>$this->mr])->andWhere(['>','next_visit','now()']);
        if ($mdl->count()>0)
            return $mdl->orderBy(['next_visit'=>SORT_DESC])->one();
        else
            return false;
    }
}
