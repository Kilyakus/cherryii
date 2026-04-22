<?php

namespace yii\cherryii\models;

use Yii;
use yii\cherryii\components\ActiveRecord;

use yii\cherryii\validators\EscapeValidator;

class LoginForm extends ActiveRecord
{
    const CACHE_KEY = 'SIGNIN_TRIES';

    private $_user = false;

    public static function tableName()
    {
        return 'cherryii_loginform';
    }

    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            [['username', 'password'], EscapeValidator::className()],
            ['password', 'validatePassword'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => Yii::t('cherryii', 'Username'),
            'password' => Yii::t('cherryii', 'Password'),
            'remember' => Yii::t('cherryii', 'Remember me')
        ];
    }

    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, Yii::t('cherryii', 'Incorrect username or password.'));
            }
        }
    }

    public function login()
    {
        $cache = Yii::$app->cache;

        if(($tries = (int)$cache->get(self::CACHE_KEY)) > 5){
            $this->addError('username', Yii::t('cherryii', 'You tried to login too often. Please wait 5 minutes.'));
            return false;
        }

        $this->ip = $_SERVER['REMOTE_ADDR'];
        $this->user_agent = $_SERVER['HTTP_USER_AGENT'];
        $this->time = time();

        if ($this->validate()) {
            $this->password = '******';
            $this->success = 1;
        } else {
            $this->success = 0;
            $cache->set(self::CACHE_KEY, ++$tries, 300);
        }
        $this->insert(false);

        return $this->success ? Yii::$app->user->login($this->getUser(), Setting::get('auth_time') ?: null ) : false;

    }

    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = Admin::findByUsername($this->username);
        }

        return $this->_user;
    }
}
