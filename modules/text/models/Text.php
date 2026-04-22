<?php
namespace yii\cherryii\modules\text\models;

use Yii;
use yii\cherryii\behaviors\CacheFlush;

class Text extends \yii\cherryii\components\ActiveRecord
{
    const CACHE_KEY = 'cherryii_text';

    public static function tableName()
    {
        return 'cherryii_texts';
    }

    public function rules()
    {
        return [
            ['text_id', 'number', 'integerOnly' => true],
            ['text', 'required'],
            ['text', 'trim'],
            ['slug', 'match', 'pattern' => self::$SLUG_PATTERN, 'message' => Yii::t('cherryii', 'Slug can contain only 0-9, a-z and "-" characters (max: 128).')],
            ['slug', 'default', 'value' => null],
            ['slug', 'unique']
        ];
    }

    public function attributeLabels()
    {
        return [
            'text' => Yii::t('cherryii', 'Text'),
            'slug' => Yii::t('cherryii', 'Slug'),
        ];
    }

    public function behaviors()
    {
        return [
            CacheFlush::className()
        ];
    }
}