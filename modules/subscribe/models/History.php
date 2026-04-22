<?php
namespace yii\cherryii\modules\subscribe\models;

use Yii;

class History extends \yii\cherryii\components\ActiveRecord
{
    public static function tableName()
    {
        return 'cherryii_subscribe_history';
    }

    public function rules()
    {
        return [
            [['subject', 'body'], 'required'],
            ['subject', 'trim'],
            ['sent', 'number', 'integerOnly' => true],
            ['time', 'default', 'value' => time()],
        ];
    }

    public function attributeLabels()
    {
        return [
            'subject' => Yii::t('cherryii/subscribe', 'Subject'),
            'body' => Yii::t('cherryii/subscribe', 'Body'),
        ];
    }
}