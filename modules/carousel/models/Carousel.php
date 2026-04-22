<?php
namespace yii\cherryii\modules\carousel\models;

use Yii;
use yii\cherryii\behaviors\CacheFlush;
use yii\cherryii\behaviors\SortableModel;

class Carousel extends \yii\cherryii\components\ActiveRecord
{
    const STATUS_OFF = 0;
    const STATUS_ON = 1;
    const CACHE_KEY = 'cherryii_carousel';

    public static function tableName()
    {
        return 'cherryii_carousel';
    }

    public function rules()
    {
        return [
            ['image', 'image'],
            [['title', 'text', 'link'], 'trim'],
            ['status', 'integer'],
            ['status', 'default', 'value' => self::STATUS_ON],
        ];
    }

    public function attributeLabels()
    {
        return [
            'image' => Yii::t('cherryii', 'Image'),
            'link' =>  Yii::t('cherryii', 'Link'),
            'title' => Yii::t('cherryii', 'Title'),
            'text' => Yii::t('cherryii', 'Text'),
        ];
    }

    public function behaviors()
    {
        return [
            CacheFlush::className(),
            SortableModel::className()
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
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

        @unlink(Yii::getAlias('@webroot').$this->image);
    }
}