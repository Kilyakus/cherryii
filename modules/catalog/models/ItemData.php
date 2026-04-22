<?php
namespace yii\cherryii\modules\catalog\models;

use Yii;
use yii\behaviors\SluggableBehavior;
use yii\cherryii\behaviors\SeoBehavior;
use yii\cherryii\behaviors\SortableModel;
use yii\cherryii\models\Photo;

class ItemData extends \yii\cherryii\components\ActiveRecord
{

    public static function tableName()
    {
        return 'cherryii_catalog_item_data';
    }
}