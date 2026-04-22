<?php
namespace yii\cherryii\behaviors;

use Yii;

/**
 * Status behavior. Adds statuses to models
 * @package yii\cherryii\behaviors
 */
class StatusController extends \yii\base\Behavior
{
    public $model;

    public function changeStatus($id, $status)
    {
        $modelClass = $this->model;

        if(($model = $modelClass::findOne($id))){
            $model->status = $status;
            $model->update();
        }
        else{
            $this->error = Yii::t('cherryii', 'Not found');
        }

        return $this->owner->formatResponse(Yii::t('cherryii', 'Status successfully changed'));
    }
}