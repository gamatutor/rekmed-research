<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "bayar".
 *
 * @property string $no_invoice
 * @property string $kunjungan_id
 * @property string $mr
 * @property string $nama_pasien
 * @property string $alamat
 * @property string $tanggal_bayar
 * @property string $subtotal
 * @property integer $diskon
 * @property string $total
 * @property string $kembali
 * @property string $bayar
 * @property string $created
 *
 * @property Kunjungan $kunjungan
 * @property BayarObat[] $bayarObats
 * @property BayarTindakan[] $bayarTindakans
 */
class Bayar extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'bayar';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_invoice'], 'required'],
            [['kunjungan_id', 'subtotal', 'diskon', 'total'], 'integer'],
            [['tanggal_bayar', 'created', 'kembali', 'bayar'], 'safe'],
            [['no_invoice'], 'string', 'max' => 20],
            [['mr'], 'string', 'max' => 25],
            [['nama_pasien', 'alamat'], 'string', 'max' => 255],
            [['kunjungan_id'], 'exist', 'skipOnError' => true, 'targetClass' => Kunjungan::className(), 'targetAttribute' => ['kunjungan_id' => 'kunjungan_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'no_invoice' => 'No Invoice',
            'kunjungan_id' => 'Kunjungan ID',
            'mr' => 'Mr',
            'nama_pasien' => 'Nama Pasien',
            'alamat' => 'Alamat',
            'tanggal_bayar' => 'Tanggal Bayar',
            'subtotal' => 'Subtotal',
            'diskon' => 'Diskon',
            'total' => 'Total',
            'kembali' => 'Kembali',
            'bayar' => 'Bayar',
            'created' => 'Created',
        ];
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
    public function getBayarObats()
    {
        return $this->hasMany(BayarObat::className(), ['no_invoice' => 'no_invoice']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBayarTindakans()
    {
        return $this->hasMany(BayarTindakan::className(), ['no_invoice' => 'no_invoice']);
    }

    public function createNoInvoice()
    {
        $connection = Yii::$app->db;
        $klinik_id = Yii::$app->user->identity->klinik_id;
        $sql = "SELECT 
                  LPAD(
                    IFNULL(
                      MAX(
                        CONVERT(SUBSTR(no_invoice, -6), UNSIGNED INTEGER)
                      ),
                      0
                    ) + 1,
                    6,
                    0
                  ) AS NEXT_INV 
                FROM
                  bayar JOIN kunjungan USING (kunjungan_id) 
                WHERE klinik_id = $klinik_id ";
        $command = $connection->createCommand($sql);
        $nextmr = $command->queryOne();
        return "INV".$klinik_id.$nextmr['NEXT_INV'];
    }

    public function getBayarObat($kunjungan_id)
    {
        $connection = Yii::$app->db;    
        
        $sql = "SELECT 
                  obat_id,
                  nama_merk,
                  rm_obat.`jumlah`,
                  harga_jual 
                FROM
                  kunjungan 
                  JOIN rekam_medis USING (kunjungan_id) 
                  JOIN rm_obat USING (rm_id) 
                  JOIN obat USING (obat_id) 
                WHERE kunjungan_id = $kunjungan_id";

        $command = $connection->createCommand($sql);
        return $command->queryAll();
    }

    public function getBayarObatRacik($kunjungan_id)
    {
        $connection = Yii::$app->db;    
        
        $sql = "SELECT 
                  obat_id,
                  nama_merk,
                  rm_obat_racik_komponen.`jumlah`,
                  harga_jual 
                FROM
                  kunjungan 
                  JOIN rekam_medis USING (kunjungan_id) 
                  JOIN rm_obat_racik USING (rm_id) 
                  JOIN rm_obat_racik_komponen USING (racik_id)
                  JOIN obat USING (obat_id) 
                WHERE kunjungan_id = $kunjungan_id";
                
        $command = $connection->createCommand($sql);
        return $command->queryAll();
    }

    public function getBayarTindakan($kunjungan_id)
    {
        $connection = Yii::$app->db;    
        
        $sql = "SELECT 
                  tindakan_id,
                  rm_tindakan.nama_tindakan,
                  (IFNULL(tarif_dokter, 0) + IFNULL(tarif_asisten, 0)) AS total_tarif 
                FROM
                  kunjungan 
                  JOIN rekam_medis USING (kunjungan_id) 
                  JOIN rm_tindakan USING (rm_id) 
                  JOIN tindakan USING (tindakan_id)
                WHERE kunjungan_id = $kunjungan_id";
                
        $command = $connection->createCommand($sql);
        return $command->queryAll();
    }

    public function getTotalPemasukanHariIni($klinik_id)
    {
        $connection = Yii::$app->db;    
        
        $sql = "SELECT 
                  SUM(total) as total
                FROM
                  bayar JOIN kunjungan USING (kunjungan_id)
                WHERE klinik_id = $klinik_id AND DATE(tanggal_bayar) = DATE(NOW()) ";
                
        $command = $connection->createCommand($sql);
        return $command->queryOne();
    }

    public function getTotalPemasukanBulanIni($klinik_id)
    {
        $connection = Yii::$app->db;    
        
        $sql = "SELECT 
                  SUM(total) as total
                FROM
                  bayar JOIN kunjungan USING (kunjungan_id)
                WHERE klinik_id = $klinik_id AND MONTH(tanggal_bayar) = MONTH(NOW()) ";
                
        $command = $connection->createCommand($sql);
        return $command->queryOne();
    }

    public function getTotalPemasukanObatHariIni($klinik_id)
    {
      $connection = Yii::$app->db;    
        
        $sql = "SELECT 
                  SUM(bayar_obat.harga_total) as total
                FROM
                  bayar_obat 
                  JOIN bayar USING (no_invoice) 
                  JOIN kunjungan USING (kunjungan_id)
                WHERE klinik_id = $klinik_id AND DATE(tanggal_bayar) = DATE(NOW()) ";
                
        $command = $connection->createCommand($sql);
        return $command->queryOne();
    }

    public function getTotalPemasukanTindakanHariIni($klinik_id)
    {
      $connection = Yii::$app->db;    
        
        $sql = "SELECT 
                  SUM(bayar_tindakan.harga) as total
                FROM
                  bayar_tindakan
                  JOIN bayar USING (no_invoice) 
                  JOIN kunjungan USING (kunjungan_id)
                WHERE klinik_id = $klinik_id AND DATE(tanggal_bayar) = DATE(NOW()) ";
                
        $command = $connection->createCommand($sql);
        return $command->queryOne();
    }
}
