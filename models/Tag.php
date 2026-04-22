<?php
namespace yii\cherryii\models;

class Tag extends \yii\cherryii\components\ActiveRecord
{
    public static function tableName()
    {
        return 'cherryii_tags';
    }

    public function rules()
    {
        return [
            ['name', 'required'],
            ['frequency', 'integer'],
            ['name', 'string', 'max' => 64],
        ];
    }
}