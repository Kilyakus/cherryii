<?php
namespace yii\cherryii\modules\file\controllers;

use Yii;
use yii\cherryii\modules\file\models\File;

class DownloadController extends \yii\web\Controller
{
    public function actionIndex($id)
    {
        $model = File::findOne($id);
        if($model){
            $model->updateCounters(['downloads' => 1]);
            Yii::$app->response->sendFile(Yii::getAlias('@webroot'). DIRECTORY_SEPARATOR .$model->file);
        }
        else{
            throw new \yii\web\NotFoundHttpException(Yii::t('cherryii/file/api', 'File not found'));
        }
    }
}
