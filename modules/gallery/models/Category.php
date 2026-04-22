<?php
namespace yii\cherryii\modules\gallery\models;

use yii\cherryii\models\Photo;

class Category extends \yii\cherryii\components\CategoryModel
{
    public static function tableName()
    {
        return 'cherryii_gallery_categories';
    }

    public function getPhotos()
    {
        return $this->hasMany(Photo::className(), ['item_id' => 'category_id'])->where(['class' => self::className()])->sort();
    }

    public function afterDelete()
    {
        parent::afterDelete();

        foreach($this->getPhotos()->all() as $photo){
            $photo->delete();
        }
    }
}