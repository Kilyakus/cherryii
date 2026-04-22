<?php
namespace yii\cherryii\modules\page\models;

use Yii;
use yii\cherryii\behaviors\SeoBehavior;

class Page extends \yii\cherryii\components\ActiveRecord
{
    public static function tableName()
    {
        return 'cherryii_pages';
    }

    public function rules()
    {
        return [
            ['title', 'required'],
            [['title', 'text'], 'trim'],
            ['title', 'string', 'max' => 128],
            ['slug', 'match', 'pattern' => self::$SLUG_PATTERN, 'message' => Yii::t('cherryii', 'Slug can contain only 0-9, a-z and "-" characters (max: 128).')],
            ['slug', 'default', 'value' => null],
            ['slug', 'unique'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'title' => Yii::t('cherryii', 'Title'),
            'text' => Yii::t('cherryii', 'Text'),
            'slug' => Yii::t('cherryii', 'Slug'),
        ];
    }

    public function behaviors()
    {
        return [
            'seoBehavior' => SeoBehavior::className(),
        ];
    }
}