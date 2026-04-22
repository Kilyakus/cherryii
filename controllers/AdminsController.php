<?php
namespace yii\cherryii\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\widgets\ActiveForm;
use yii\cherryii\models\Admin;

class AdminsController extends \yii\cherryii\components\Controller
{
    public $rootActions = 'all';

    public function actionIndex()
    {
        $data = new ActiveDataProvider([
            'query' => Admin::find()->desc(),
        ]);
        Yii::$app->user->setReturnUrl(['/admin/admins']);

        return $this->render('index', [
            'data' => $data
        ]);
    }

    public function actionCreate()
    {
        $model = new Admin;
        $model->scenario = 'create';

        if ($model->load(Yii::$app->request->post())) {
            if(Yii::$app->request->isAjax){
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
            else{
                if($model->save()){
                    $this->flash('success', Yii::t('cherryii', 'Admin created'));
                    return $this->redirect(['/admin/admins']);
                }
                else{
                    $this->flash('error', Yii::t('cherryii', 'Create error. {0}', $model->formatErrors()));
                    return $this->refresh();
                }
            }
        }
        else {
            return $this->render('create', [
                'model' => $model
            ]);
        }
    }

    public function actionEdit($id)
    {
        $model = Admin::findOne($id);

        if($model === null){
            $this->flash('error', Yii::t('cherryii', 'Not found'));
            return $this->redirect(['/admin/admins']);
        }

        if ($model->load(Yii::$app->request->post())) {
            if(Yii::$app->request->isAjax){
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
            else{
                if($model->save()){
                    $this->flash('success', Yii::t('cherryii', 'Admin updated'));
                }
                else{
                    $this->flash('error', Yii::t('cherryii', 'Update error. {0}', $model->formatErrors()));
                }
                return $this->refresh();
            }
        }
        else {
            return $this->render('edit', [
                'model' => $model
            ]);
        }
    }

    public function actionDelete($id)
    {
        if(($model = Admin::findOne($id))){
            $model->delete();
        } else {
            $this->error = Yii::t('cherryii', 'Not found');
        }
        return $this->formatResponse(Yii::t('cherryii', 'Admin deleted'));
    }
}