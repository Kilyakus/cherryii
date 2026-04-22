<?php
$this->title = Yii::t('cherryii/article', 'Create article');
?>
<?= $this->render('_menu', ['category' => $category]) ?>
<?= $this->render('_form', ['model' => $model]) ?>