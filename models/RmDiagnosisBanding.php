<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "rm_diagnosis_banding".
 *
 * @property string $id
 * @property string $rm_id
 * @property string $kode
 *
 * @property Diagnosis $kode0
 * @property RekamMedis $rm
 */
class RmDiagnosisBanding extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rm_diagnosis_banding';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['rm_id'], 'integer'],
            [['kode'], 'string', 'max' => 15],
            [['nama_diagnosis'],'string','max'=>255],
            [['kode'], 'exist', 'skipOnError' => true, 'targetClass' => Diagnosis::className(), 'targetAttribute' => ['kode' => 'kode']],
            [['rm_id'], 'exist', 'skipOnError' => true, 'targetClass' => RekamMedis::className(), 'targetAttribute' => ['rm_id' => 'rm_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'rm_id' => 'Rm ID',
            'kode' => 'Kode',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKode0()
    {
        return $this->hasOne(Diagnosis::className(), ['kode' => 'kode']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRm()
    {
        return $this->hasOne(RekamMedis::className(), ['rm_id' => 'rm_id']);
    }
}
