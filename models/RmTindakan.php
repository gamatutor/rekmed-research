<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "rm_tindakan".
 *
 * @property string $id
 * @property string $rm_id
 * @property integer $tindakan_id
 *
 * @property RekamMedis $rm
 * @property Tindakan $tindakan
 */
class RmTindakan extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rm_tindakan';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['rm_id', 'tindakan_id'], 'integer'],
            [['nama_tindakan'],'string','max'=>255],
            [['rm_id'], 'exist', 'skipOnError' => true, 'targetClass' => RekamMedis::className(), 'targetAttribute' => ['rm_id' => 'rm_id']],
            [['tindakan_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tindakan::className(), 'targetAttribute' => ['tindakan_id' => 'tindakan_id']],
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
            'tindakan_id' => 'Tindakan ID',
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
    public function getTindakan()
    {
        return $this->hasOne(Tindakan::className(), ['tindakan_id' => 'tindakan_id']);
    }
}
