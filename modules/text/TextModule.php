<?php
namespace yii\cherryii\modules\text;

class TextModule extends \yii\cherryii\components\Module
{
    public static $installConfig = [
        'title' => [
            'en' => 'Text blocks',
            'ru' => 'Текстовые блоки',
        ],
        'icon' => 'font',
        'order_num' => 20,
    ];
}