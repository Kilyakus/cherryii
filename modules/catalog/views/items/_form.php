<?php
use yii\cherryii\helpers\Image;
use yii\cherryii\widgets\DateTimePicker;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\cherryii\widgets\Redactor;
use yii\cherryii\widgets\SeoForm;

$settings = $this->context->module->settings;
$module = $this->context->module->id;
?>

<?php $form = ActiveForm::begin([
    'options' => ['enctype' => 'multipart/form-data', 'class' => 'model-form']
]); ?>
<?= $form->field($model, 'title') ?>
<?php if($settings['itemThumb']) : ?>
    <?php if($model->image) : ?>
        <img src="<?= Image::thumb($model->image, 240) ?>">
        <a href="<?= Url::to(['/admin/'.$module.'/items/clear-image', 'id' => $model->primaryKey]) ?>" class="text-danger confirm-delete" title="<?= Yii::t('cherryii', 'Clear image')?>"><?= Yii::t('cherryii', 'Clear image')?></a>
    <?php endif; ?>
    <?= $form->field($model, 'image')->fileInput() ?>
<?php endif; ?>
<?= $dataForm ?>
<?php if($settings['itemDescription']) : ?>
    <?= $form->field($model, 'description')->widget(Redactor::className(),[
        'options' => [
            'minHeight' => 400,
            'imageUpload' => Url::to(['/admin/redactor/upload', 'dir' => 'catalog'], true),
            'fileUpload' => Url::to(['/admin/redactor/upload', 'dir' => 'catalog'], true),
            'plugins' => ['fullscreen']
        ]
    ]) ?>
<?php endif; ?>

<?= $form->field($model, 'available') ?>
<?= $form->field($model, 'price') ?>
<?= $form->field($model, 'discount') ?>

<?= $form->field($model, 'time')->widget(DateTimePicker::className()); ?>

<?php if(IS_ROOT) : ?>
    <?= $form->field($model, 'slug') ?>
    <?= SeoForm::widget(['model' => $model]) ?>
<?php endif; ?>

<?= Html::submitButton(Yii::t('cherryii', 'Save'), ['class' => 'btn btn-primary']) ?>
<?php ActiveForm::end(); ?>