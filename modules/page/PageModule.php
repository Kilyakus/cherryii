<?php
namespace yii\cherryii\modules\page;

use Yii;

class PageModule extends \yii\cherryii\components\Module
{
    public static $installConfig = [
        'title' => [
            'en' => 'Pages',
            'ru' => 'Страницы',
        ],
        'icon' => 'file',
        'order_num' => 50,
    ];
}