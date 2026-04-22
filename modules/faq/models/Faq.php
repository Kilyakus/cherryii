<?php
namespace yii\cherryii\modules\faq\models;

use Yii;
use yii\cherryii\behaviors\CacheFlush;
use yii\cherryii\behaviors\SortableModel;

class Faq extends \yii\cherryii\components\ActiveRecord
{
    const STATUS_OFF = 0;
    const STATUS_ON = 1;

    const CACHE_KEY = 'cherryii_faq';

    public static function tableName()
    {
        return 'cherryii_faq';
    }

    public function rules()
    {
        return [
            [['question','answer'], 'required'],
            [['question', 'answer'], 'trim'],
            ['status', 'integer'],
            ['status', 'default', 'value' => self::STATUS_ON],
        ];
    }

    public function attributeLabels()
    {
        return [
            'question' => Yii::t('cherryii/faq', 'Question'),
            'answer' => Yii::t('cherryii/faq', 'Answer'),
        ];
    }

    public function behaviors()
    {
        return [
            CacheFlush::className(),
            SortableModel::className()
        ];
    }
}