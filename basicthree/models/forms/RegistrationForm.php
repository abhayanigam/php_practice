<?php

namespace app\models\forms;

use yii\base\Model;

class RegistrationForm extends Model
{
    public $username;
    public $email;
    public $password;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'email', 'password'], 'required'],
            [['username'], 'string', 'max' => 255],
            [['email'], 'email'],
            [['email'], 'unique', 'targetClass' => '\app\models\User', 'message' => 'This email address has already been taken.'],
            [['username'], 'unique', 'targetClass' => '\app\models\User', 'message' => 'This username has already been taken.'],
            [['password'], 'string', 'min' => 6],
        ];
    }
}
