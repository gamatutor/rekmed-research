<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "diagnosis".
 *
 * @property string $kode
 * @property string $kode_root
 * @property string $nama
 *
 * @property RmDiagnosis[] $rmDiagnoses
 * @property RmDiagnosisBanding[] $rmDiagnosisBandings
 */
class Diagnosis extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'diagnosis';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['kode'], 'required'],
            [['kode', 'kode_root'], 'string', 'max' => 15],
            [['nama'], 'string', 'max' => 1000],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'kode' => 'Kode',
            'kode_root' => 'Kode Root',
            'nama' => 'Nama',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRmDiagnoses()
    {
        return $this->hasMany(RmDiagnosis::className(), ['kode' => 'kode']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRmDiagnosisBandings()
    {
        return $this->hasMany(RmDiagnosisBanding::className(), ['kode' => 'kode']);
    }
}
