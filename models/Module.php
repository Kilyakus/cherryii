<?php
namespace yii\cherryii\models;

use Yii;

use yii\cherryii\helpers\Data;
use yii\cherryii\behaviors\CacheFlush;
use yii\cherryii\behaviors\SortableModel;

class Module extends \yii\cherryii\components\ActiveRecord
{
    const STATUS_OFF= 0;
    const STATUS_ON = 1;

    const CACHE_KEY = 'cherryii_modules';

    public static function tableName()
    {
        return 'cherryii_modules';
    }

    public function rules()
    {
        return [
            [['name', 'class', 'title'], 'required'],
            [['name', 'class', 'title', 'icon'], 'trim'],
            ['name',  'match', 'pattern' => '/^[a-z]+$/'],
            ['name', 'unique'],
            ['class',  'match', 'pattern' => '/^[\w\\\]+$/'],
            ['class',  'checkExists'],
            ['icon', 'string'],
            ['status', 'in', 'range' => [0,1]],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => Yii::t('cherryii', 'Name'),
            'class' => Yii::t('cherryii', 'Class'),
            'title' => Yii::t('cherryii', 'Title'),
            'icon' => Yii::t('cherryii', 'Icon'),
            'order_num' => Yii::t('cherryii', 'Order'),
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
            if(!$this->settings || !is_array($this->settings)){
                $this->settings = self::getDefaultSettings($this->name);
            }
            $this->settings = json_encode($this->settings);

            return true;
        } else {
            return false;
        }
    }

    public function afterFind()
    {
        parent::afterFind();
        $this->settings = $this->settings !== '' ? json_decode($this->settings, true) : self::getDefaultSettings($this->name);
    }

    public static function findAllActive()
    {
        return Data::cache(self::CACHE_KEY, 3600, function(){
            $result = [];
            try {
                foreach (self::find()->where(['status' => self::STATUS_ON])->sort()->all() as $module) {
                    $module->trigger(self::EVENT_AFTER_FIND);
                    $result[$module->name] = (object)$module->attributes;
                }
            }catch(\yii\db\Exception $e){}

            return $result;
        });
    }

    public function setSettings($settings)
    {
        $newSettings = [];
        foreach($this->settings as $key => $value){
            $newSettings[$key] = is_bool($value) ? ($settings[$key] ? true : false) : ($settings[$key] ? $settings[$key] : '');
        }
        $this->settings = $newSettings;
    }

    public function checkExists($attribute)
    {
        if(!class_exists($this->$attribute)){
            $this->addError($attribute, Yii::t('cherryii', 'Class does not exist'));
        }
    }

    static function getDefaultSettings($moduleName)
    {
        $modules = Yii::$app->getModule('admin')->activeModules;
        if(isset($modules[$moduleName])){
            return Yii::createObject($modules[$moduleName]->class, [$moduleName])->settings;
        } else {
            return [];
        }
    }

}