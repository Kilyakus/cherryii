<?php
namespace yii\cherryii\modules\article\controllers;

use yii\cherryii\components\CategoryController;

class AController extends CategoryController
{
    /** @var string  */
    public $categoryClass = 'yii\cherryii\modules\article\models\Category';

    /** @var string  */
    public $moduleName = 'article';
}