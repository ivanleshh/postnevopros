<?php

namespace app\models;

use Yii;
use app\models\Role;
use app\models\Post;
use yii\db\Query;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $name
 * @property string $surname
 * @property string|null $patronymic
 * @property string $email
 * @property string $password
 * @property string|null $avatar
 * @property string $login
 * @property string $auth_key
 * @property string $created_at
 * @property string $phone
 * @property int $role_id
 * @property int $is_block
 * @property string $expire_block|null
 *
 * @property Post[] $posts
 * @property Role $role
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    const NO_PHOTO = 'noPhoto.png';
    public $check = false;
    const SCENARIO_DATE = 'date';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'surname', 'email', 'password', 'login', 'auth_key', 'phone', 'role_id'], 'required'],
            [['created_at', 'is_block'], 'safe'],
            [['role_id'], 'integer'],
            [['name', 'surname', 'patronymic', 'email', 'password', 'avatar', 'login', 'auth_key', 'phone', 'expire_block'], 'string', 'max' => 255],
            [['role_id'], 'exist', 'skipOnError' => true, 'targetClass' => Role::class, 'targetAttribute' => ['role_id' => 'id']],

            ['expire_block', 'required', 'on' => self::SCENARIO_DATE],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => '№',
            'auth_key' => 'Ключ аутентификации',
            'created_at' => 'Создан',
            'phone' => 'телефон',
            'role_id' => 'Роль',
            'expire_block' => 'Заблокирован до',
            'is_block' => 'Заблокирован',
            'check' => 'Заблокировать на время',
        ];
    }

    /**
     * Finds an identity by the given ID.
     *
     * @param string|int $id the ID to be looked for
     * @return IdentityInterface|null the identity object that matches the given ID.
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * Finds an identity by the given token.
     *
     * @param string $token the token to be looked for
     * @return IdentityInterface|null the identity object that matches the given token.
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    /**
     * @return int|string current user ID
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string|null current user auth key
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @param string $authKey
     * @return bool|null if auth key is valid for current user
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Gets query for [[Posts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPosts()
    {
        return $this->hasMany(Post::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Role]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRole()
    {
        return $this->hasOne(Role::class, ['id' => 'role_id']);
    }

    public static function findByLogin($login): object|null
    {
        return self::findOne(['login' => $login]);
    }

    public function validatePassword($password): bool
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    public function getIsAdmin(): bool
    {
        return $this->role_id == Role::getRoleId('администратор системы');
    }

    public static function getUsers()
    {
        return self::find()->select('login')->indexBy('id')->column();
    }

    public function getFio()
    {
        return $this->name . ' ' . $this->surname . ($this->patronymic ? ' ' . $this->patronymic : '');
    }
}
