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
class LoginForm extends Model
{
    public $login;
    public $password;
    public $rememberMe = true;

    private $_user = false;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['login', 'password'], 'required'],
            [['login'], 'match', 'pattern' => '/^[a-z\-]+$/i', 'message' => 'Латиница и тире'],
            ['password', 'string', 'min' => 6, 'message' => 'Поле должно быть больше 6 символов'],
            ['password', 'validatePassword'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'login' => 'login',
            'password' => 'password',
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !$user->validatePassword($this->password)) {
                Yii::$app->session->setFlash('warning', 'Пара логин-пароль введены некорректно');
                $this->addError($attribute, 'Неверный логин или пароль.');
            }
        }
    }

    /**
     * Logs in a user using the provided login and password.
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            $user = $this->getUser();
            if ($user->is_block) {
                if (isset($user->expire_block)) {
                    Yii::$app->session->setFlash('danger', "Учётная запись заблокирована до " . Yii::$app->formatter->asDate($user->expire_block, 'php:d.m.Y'));
                } else {
                    Yii::$app->session->setFlash('danger', "Учётная запись заблокирована");
                }
                return false;
                
            }
            return Yii::$app->user->login($user, $this->rememberMe ? 3600*24*30 : 0);
        }
        return false;
    }

    /**
     * Finds user by [[login]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByLogin($this->login);
        }

        return $this->_user;
    }
}
