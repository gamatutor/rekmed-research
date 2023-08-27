<?php

namespace app\models;
use dosamigos\datepicker\DatePicker;
use Yii;

/**
 * This is the model class for table "pasien_next_visit".
 *
 * @property integer $pasien_schedule_id
 * @property string $mr
 * @property string $agenda
 * @property string $desc
 * @property string $next_visit
 * @property string $created_at
 */
class PasienNextVisit extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pasien_next_visit';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['next_visit','agenda','created_by'], 'required'],
            [['pasien_schedule_id','created_by'], 'integer'],
            [['desc'], 'string'],
            [['next_visit', 'created_at'], 'safe'],
            [['mr'], 'string', 'max' => 25],
            [['agenda'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'pasien_schedule_id' => 'Pasien Schedule ID',
            'mr' => 'Rekam Medis',
            'agenda' => 'Agenda',
            'desc' => 'Catatan',
            'next_visit' => 'Waktu Kunjungan Berikutya',
            'created_at' => 'Created At',
        ];
    }

    public function getPasien()
    {
        return $this->hasOne(Pasien::className(), ['mr' => 'mr']);
    }
}
