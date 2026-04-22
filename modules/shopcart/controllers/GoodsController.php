<?php
namespace yii\cherryii\modules\shopcart\controllers;

use Yii;

use yii\cherryii\components\Controller;
use yii\cherryii\modules\shopcart\models\Good;

class GoodsController extends Controller
{
    public function actionDelete($id)
    {
        if(($model = Good::findOne($id))){
            $model->delete();
        } else {
            $this->error = Yii::t('cherryii', 'Not found');
        }
        return $this->formatResponse(Yii::t('cherryii/shopcart', 'Order deleted'));
    }
}