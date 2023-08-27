<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "rm_obat_racik".
 *
 * @property integer $racik_id
 * @property string $rm_id
 * @property integer $jumlah
 * @property string $signa
 *
 * @property RekamMedis $rm
 * @property RmObatRacikKomponen[] $rmObatRacikKomponens
 */
class RmObatRacik extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rm_obat_racik';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['rm_id', 'jumlah'], 'integer'],
            [['signa'], 'string', 'max' => 255],
            [['rm_id'], 'exist', 'skipOnError' => true, 'targetClass' => RekamMedis::className(), 'targetAttribute' => ['rm_id' => 'rm_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'racik_id' => 'Racik ID',
            'rm_id' => 'Rm ID',
            'jumlah' => 'Jumlah',
            'signa' => 'Signa',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRm()
    {
        return $this->hasOne(RekamMedis::className(), ['rm_id' => 'rm_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRmObatRacikKomponens()
    {
        return $this->hasMany(RmObatRacikKomponen::className(), ['racik_id' => 'racik_id']);
    }
}
