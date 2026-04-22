<?php
use yii\cherryii\widgets\Photos;

$this->title = $model->title;
?>

<?= $this->render('@cherryii/views/category/_menu') ?>

<?= Photos::widget(['model' => $model])?>