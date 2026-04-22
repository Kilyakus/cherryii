<?php
namespace yii\cherryii\modules\faq;

use Yii;

class FaqModule extends \yii\cherryii\components\Module
{
    public static $installConfig = [
        'title' => [
            'en' => 'FAQ',
            'ru' => 'Вопросы и ответы',
        ],
        'icon' => 'question-sign',
        'order_num' => 45,
    ];
}