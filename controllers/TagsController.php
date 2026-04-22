<?php
namespace yii\cherryii\controllers;

use Yii;
use yii\cherryii\models\Tag;
use yii\helpers\Html;
use yii\web\Response;

class TagsController extends \yii\cherryii\components\Controller
{
    public function actionList($query)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $items = [];
        $query = urldecode(mb_convert_encoding($query, "UTF-8"));
        foreach (Tag::find()->where(['like', 'name', $query])->asArray()->all() as $tag) {
            $items[] = ['name' => $tag['name']];
        }

        return $items;
    }
}