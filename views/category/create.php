<?php
$this->title = Yii::t('cherryii', 'Create category');
?>
<?= $this->render('_menu') ?>
<?= $this->render('_form', ['model' => $model, 'parent' => $parent]) ?>