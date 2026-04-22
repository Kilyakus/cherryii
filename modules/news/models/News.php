<?php
namespace yii\cherryii\modules\news\models;

use Yii;
use yii\behaviors\SluggableBehavior;
use yii\cherryii\behaviors\SeoBehavior;
use yii\cherryii\behaviors\Taggable;
use yii\cherryii\models\Photo;
use yii\helpers\StringHelper;

class News extends \yii\cherryii\components\ActiveRecord
{
    const STATUS_OFF = 0;
    const STATUS_ON = 1;

    public static function tableName()
    {
        return 'cherryii_news';
    }

    public function rules()
    {
        return [
            [['text', 'title'], 'required'],
            [['title', 'short', 'text'], 'trim'],
            ['title', 'string', 'max' => 128],
            ['image', 'image'],
            [['views', 'time', 'status'], 'integer'],
            ['time', 'default', 'value' => time()],
            ['slug', 'match', 'pattern' => self::$SLUG_PATTERN, 'message' => Yii::t('cherryii', 'Slug can contain only 0-9, a-z and "-" characters (max: 128).')],
            ['slug', 'default', 'value' => null],
            ['status', 'default', 'value' => self::STATUS_ON],
            ['tagNames', 'safe']
        ];
    }

    public function attributeLabels()
    {
        return [
            'title' => Yii::t('cherryii', 'Title'),
            'text' => Yii::t('cherryii', 'Text'),
            'short' => Yii::t('cherryii/news', 'Short'),
            'image' => Yii::t('cherryii', 'Image'),
            'time' => Yii::t('cherryii', 'Date'),
            'slug' => Yii::t('cherryii', 'Slug'),
            'tagNames' => Yii::t('cherryii', 'Tags'),
        ];
    }

    public function behaviors()
    {
        return [
            'seoBehavior' => SeoBehavior::className(),
            'taggabble' => Taggable::className(),
            'sluggable' => [
                'class' => SluggableBehavior::className(),
                'attribute' => 'title',
                'ensureUnique' => true
            ],
        ];
    }

    public function getPhotos()
    {
        return $this->hasMany(Photo::className(), ['item_id' => 'news_id'])->where(['class' => self::className()])->sort();
    }



    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $settings = Yii::$app->getModule('admin')->activeModules['news']->settings;
            $this->short = StringHelper::truncate($settings['enableShort'] ? $this->short : strip_tags($this->text), $settings['shortMaxLength']);

            if(!$insert && $this->image != $this->oldAttributes['image'] && $this->oldAttributes['image']){
                @unlink(Yii::getAlias('@webroot').$this->oldAttributes['image']);
            }
            return true;
        } else {
            return false;
        }
    }

    public function afterDelete()
    {
        parent::afterDelete();

        if($this->image){
            @unlink(Yii::getAlias('@webroot').$this->image);
        }

        foreach($this->getPhotos()->all() as $photo){
            $photo->delete();
        }
    }
}