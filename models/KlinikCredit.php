<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "klinik_credit".
 *
 * @property string $credit_id
 * @property integer $klinik_id
 * @property string $penambahan
 * @property string $biaya
 * @property integer $user_id
 * @property string $created
 *
 * @property Klinik $klinik
 * @property User $user
 */
class KlinikCredit extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'klinik_credit';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['klinik_id', 'penambahan', 'biaya', 'user_id'], 'integer'],
            [['created'], 'safe'],
            [['klinik_id'], 'exist', 'skipOnError' => true, 'targetClass' => Klinik::className(), 'targetAttribute' => ['klinik_id' => 'klinik_id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'credit_id' => 'Credit ID',
            'klinik_id' => 'Klinik ID',
            'penambahan' => 'Penambahan',
            'biaya' => 'Biaya',
            'user_id' => 'User ID',
            'created' => 'Created',
        ];
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
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
