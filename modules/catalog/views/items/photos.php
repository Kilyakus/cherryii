<?php
use yii\cherryii\widgets\Photos;

$this->title = Yii::t('cherryii', 'Photos') . ' ' . $model->title;
?>

<?= $this->render('_menu', ['category' => $model->category]) ?>
<?= $this->render('_submenu', ['model' => $model]) ?>

<?= Photos::widget(['model' => $model])?>