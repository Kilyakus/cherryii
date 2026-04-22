<?php
namespace yii\cherryii\modules\gallery\controllers;

use yii\cherryii\components\CategoryController;
use yii\cherryii\modules\gallery\models\Category;

class AController extends CategoryController
{
    public $categoryClass = 'yii\cherryii\modules\gallery\models\Category';
    public $moduleName = 'gallery';
    public $viewRoute = '/a/photos';

    public function actionPhotos($id)
    {
        if(!($model = Category::findOne($id))){
            return $this->redirect(['/admin/'.$this->module->id]);
        }

        return $this->render('photos', [
            'model' => $model,
        ]);
    }
}