<?php
$this->title = Yii::t('cherryii/page', 'Create page');
?>
<?= $this->render('_menu') ?>
<?= $this->render('_form', ['model' => $model]) ?>