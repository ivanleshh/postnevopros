<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property-read User|null $user
 *
 */
class RegisterForm extends Model
{
    public string $login = '';
    public string $password = '';
    public string $password_repeat = '';
    public string $name = '';
    public string $surname = '';
    public string $patronymic = '';
    public string $email = '';
    public ?string $avatar = null;
    public string $phone = '';
    public bool $rules = false;
    public object|string|null $imageFile = null;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['name', 'surname', 'email', 'password', 'password_repeat', 'login', 'phone'], 'required'],
            [['email', 'login'], 'unique', 'targetClass' => User::class],
            [['name', 'surname', 'patronymic', 'email', 'password', 'password_repeat', 'login', 'phone'], 'string', 'max' => 255],
            [['name', 'surname', 'patronymic'], 'match', 'pattern' => '/^[а-яё\s\-]+$/ui', 'message' => 'Кириллица, пробел и тире'],
            [['login'], 'match', 'pattern' => '/^[a-z\-]+$/i', 'message' => 'Латиница и тире'],
            ['email', 'email'],
            ['avatar', 'safe'],
            ['password', 'string', 'min' => 6, 'message' => 'Поле должно быть больше 6 символов'],
            ['phone', 'match', 'pattern' => '/^\+7\([\d]{3}\)\-[\d]{3}(\-[\d]{2}){2}$/', 'message' => 'Формат +7(XXX)-XXX-XX-XX'],
            ['password_repeat', 'compare', 'compareAttribute' => 'password'],
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
            ['rules', 'required', 'requiredValue' => true, 'message' => 'Необходимо согласиться с правилами регистрации'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'name',
            'surname' => 'surname',
            'patronymic' => 'patronymic',
            'email' => 'email',
            'password' => 'password',
            'password_repeat' => 'password_repeat',
            'avatar' => 'avatar',
            'login' => 'login',
            'phone' => 'телефон',
            'rules' => 'rules',
            'imageFile' => 'avatar',
        ];
    }

    public function userRegister(): object|false
    {
        if ($this->validate()) {
            $user = new User;
            $user->load($this->attributes, '');
            $user->password = Yii::$app->security->generatePasswordHash($user->password);
            $user->auth_key = Yii::$app->security->generateRandomString();
            $user->role_id = Role::getRoleId('автор');
            $user->save(false);
        }
        return $user ?? false;
    }

    // Сохранение файла в папку на сервере
    public function upload()
    {
        if ($this->validate()) {
            $fileName = Yii::$app->security->generateRandomString()
                . '_'
                . time()
                . '.'
                . $this->imageFile->extension;

            $this->imageFile->saveAs('img/' . $fileName);
            $this->imageFile = null;
            $this->avatar = $fileName;
            return true;
        } else {
            return false;
        }
    }
}
