<?php
namespace yii\cherryii\modules\carousel;

class CarouselModule extends \yii\cherryii\components\Module
{
    public $settings = [
        'enableTitle' => true,
        'enableText' => true,
    ];

    public static $installConfig = [
        'title' => [
            'en' => 'Carousel',
            'ru' => 'Карусель',
        ],
        'icon' => 'picture',
        'order_num' => 40,
    ];
}