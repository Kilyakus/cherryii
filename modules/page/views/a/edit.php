<?php
$this->title = Yii::t('cherryii/page', 'Edit page');
?>
<?= $this->render('_menu') ?>
<?= $this->render('_form', ['model' => $model]) ?>