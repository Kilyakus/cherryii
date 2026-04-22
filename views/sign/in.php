<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$asset = \yii\cherryii\assets\EmptyAsset::register($this);
$this->title = Yii::t('cherryii', 'Sign in');
?>
<div class="container">
    <div id="wrapper" class="col-md-4 col-md-offset-4 vertical-align-parent">
        <div class="vertical-align-child">
            <div class="panel">
                <div class="panel-heading text-center">
                    <?= Yii::t('cherryii', 'Sign in') ?>
                </div>
                <div class="panel-body">
                    <?php $form = ActiveForm::begin([
                        'fieldConfig' => [
                            'template' => "{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}"
                        ]
                    ])
                    ?>
                        <?= $form->field($model, 'username')->textInput(['class'=>'form-control', 'placeholder'=>Yii::t('cherryii', 'Username')]) ?>
                        <?= $form->field($model, 'password')->passwordInput(['class'=>'form-control', 'placeholder'=>Yii::t('cherryii', 'Password')]) ?>
                        <?=Html::submitButton(Yii::t('cherryii', 'Login'), ['class'=>'btn btn-lg btn-primary btn-block']) ?>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
            <div class="text-center">
                <a class="logo" href="http://cherryiicms.com" target="_blank" title="cherryiiCMS homepage">
                    <img src="<?= $asset->baseUrl ?>/img/logo_20.png">cherryiiCMS
                </a>
            </div>
        </div>
    </div>
</div>
