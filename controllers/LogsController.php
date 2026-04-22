<?php
namespace yii\cherryii\controllers;

use yii\data\ActiveDataProvider;

use yii\cherryii\models\LoginForm;

class LogsController extends \yii\cherryii\components\Controller
{
    public $rootActions = 'all';

    public function actionIndex()
    {
        $data = new ActiveDataProvider([
            'query' => LoginForm::find()->desc(),
        ]);

        return $this->render('index', [
            'data' => $data
        ]);
    }
}