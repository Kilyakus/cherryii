<?php
use yii\cherryii\widgets\Photos;

$this->title = $model->title;
?>

<?= $this->render('_menu') ?>
<?= $this->render('_submenu', ['model' => $model]) ?>

<?= Photos::widget(['model' => $model])?>