<?php

namespace app\models;
use Yii;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property integer $klinik_id
 * @property integer $status
 * @property integer $role
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Dokter $dokter
 * @property RekamMedis[] $rekamMedis
 * @property Klinik $klinik
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{
    /**
     * @inheritdoc
     */

    const ROLE_ADMIN = 10;
    const ROLE_DOKTER_ADMIN = 20;
    const ROLE_DOKTER = 25;

    public static function tableName()
    {
        return 'user';
    }

    public function delete(){
        $this->status = '00';
        return $this->save();
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'password_hash'], 'required'],
            [['klinik_id', 'status', 'role'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['apps_id','apps','username', 'password_hash', 'password_reset_token', 'email'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['username'], 'unique'],
            [['email'], 'unique'],
            [['password_reset_token'], 'unique'],
            [['klinik_id'], 'exist', 'skipOnError' => true, 'targetClass' => Klinik::className(), 'targetAttribute' => ['klinik_id' => 'klinik_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'apps' => 'Apps',
            'apps_id' => 'ID Apps',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'email' => 'Email',
            'klinik_id' => 'Klinik / RS',
            'status' => 'Status',
            'role' => 'Role',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDokter()
    {
        return $this->hasOne(Dokter::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRekamMedis()
    {
        return $this->hasMany(RekamMedis::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKlinik()
    {
        return $this->hasOne(Klinik::className(), ['klinik_id' => 'klinik_id']);
    }

    /** INCLUDE USER LOGIN VALIDATION FUNCTIONS**/
    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * @inheritdoc
     */

    public static function findIdentityByAccessToken($token, $type = null)
    {
          return static::findOne(['access_token' => $token]);
    }
 

    /**
     * Finds user by username
     *
     * @param  string      $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username,'status'=>10]);
    }

    /**
     * Finds user by password reset token
     *
     * @param  string      $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        $expire = \Yii::$app->params['user.passwordResetTokenExpire'];
        $parts = explode('_', $token);
        $timestamp = (int) end($parts);
        if ($timestamp + $expire < time()) {
            // token expired
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token
        ]);
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    public function getRuang()
    {
        return $this->hasOne(Ruang::className(), ['id' => 'ruang_id']);
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param  string  $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomKey() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    public function getSpesialis()
    {
        if($this->dokter!=null)
            return $this->dokter->spesialis;
        else
            return -1;
    }

    public function getRealUsername()
    {
        $session = Yii::$app->session;
        if ($session->get('realUsername')!='' && $session->get('switchedUsername')!='')
            return $session->get('realUsername');
        else
            return '';
    }

    public function destroySimulationSession()
    {
        $session = Yii::$app->session;
        
        $session->remove('realUsername');
        $session->remove('switchedUsername');
    }

    public function getReadableName()
    {
        if($this->dokter->nama=='[Isi Nama Anda]')
            return $this->username;
        else
            return $this->dokter->nama;
    }
}
