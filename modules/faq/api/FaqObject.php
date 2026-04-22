<?php
namespace yii\cherryii\modules\faq\api;

use yii\cherryii\components\API;
use yii\helpers\Url;

class FaqObject extends \yii\cherryii\components\ApiObject
{
    public function getQuestion(){
        return LIVE_EDIT ? API::liveEdit($this->model->question, $this->editLink) : $this->model->question;
    }

    public function getAnswer(){
        return LIVE_EDIT ? API::liveEdit($this->model->answer, $this->editLink) : $this->model->answer;
    }

    public function  getEditLink(){
        return Url::to(['/admin/faq/a/edit/', 'id' => $this->id]);
    }
}