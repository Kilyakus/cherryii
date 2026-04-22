<?php
namespace yii\cherryii\controllers;

class DefaultController extends \yii\cherryii\components\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}