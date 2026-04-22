<?php
use yii\helpers\Html;
use yii\cherryii\modules\feedback\models\Feedback;
use yii\widgets\ActiveForm;

$this->title = Yii::t('cherryii/feedback', 'View feedback');
$this->registerCss('.feedback-view dt{margin-bottom: 10px;}');

if($model->status == Feedback::STATUS_ANSWERED) {
    $this->registerJs('$(".send-answer").click(function(){return confirm("'.Yii::t('cherryii/feedback', 'Are you sure you want to resend the answer?').'");})');
}
?>
<?= $this->render('_menu', ['noanswer' => $model->status == Feedback::STATUS_ANSWERED]) ?>

<dl class="dl-horizontal feedback-view">
    <dt><?= Yii::t('cherryii', 'Name') ?></dt>
    <dd><?= $model->name ?></dd>

    <dt>E-mail</dt>
    <dd><?= $model->email ?></dd>

    <?php if($this->context->module->settings['enablePhone']) : ?>
    <dt><?= Yii::t('cherryii/feedback', 'Phone') ?></dt>
    <dd><?= $model->phone ?></dd>
    <?php endif; ?>

    <?php if($this->context->module->settings['enableTitle']) : ?>
    <dt><?= Yii::t('cherryii', 'Title') ?></dt>
    <dd><?= $model->title ?></dd>
    <?php endif; ?>

    <dt>IP</dt>
    <dd><?= $model->ip ?> <a href="//freegeoip.net/?q=<?= $model->ip ?>" class="label label-info" target="_blank">info</a></dd>

    <dt><?= Yii::t('cherryii', 'Date') ?></dt>
    <dd><?= Yii::$app->formatter->asDatetime($model->time, 'medium') ?></dd>

    <dt><?= Yii::t('cherryii', 'Text') ?></dt>
    <dd><?= nl2br($model->text) ?></dd>
</dl>

<hr>
<h2><small><?= Yii::t('cherryii/feedback', 'Answer') ?></small></h2>

<?php $form = ActiveForm::begin() ?>
    <?= $form->field($model, 'answer_subject') ?>
    <?= $form->field($model, 'answer_text')->textarea(['style' => 'height: 250px']) ?>
    <?= Html::submitButton(Yii::t('cherryii', 'Send'), ['class' => 'btn btn-success send-answer']) ?>
<?php ActiveForm::end() ?>