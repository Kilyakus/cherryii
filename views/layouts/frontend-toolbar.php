<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\cherryii\assets\FrontendAsset;
use yii\cherryii\models\Setting;

$asset = FrontendAsset::register($this);
$position = Setting::get('toolbar_position') === 'bottom' ? 'bottom' : 'top';
$this->registerCss('body {padding-'.$position.': 50px;}');
?>
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=latin,cyrillic' rel='stylesheet' type='text/css'>
<nav id="cherryii-navbar" class="navbar navbar-dark bg-dark fixed-<?= $position ?> navbar-expand">
    <div class="container">
        <ul class="navbar-nav me-auto">
            <li class="nav-item">
                <a class="nav-link" href="<?= Url::to(['/admin']) ?>">
                    <i class="bi bi-arrow-left"></i> <?= Yii::t('cherryii', 'Control Panel') ?>
                </a>
            </li>
        </ul>
        <span class="navbar-text d-flex align-items-center">
            <i class="bi bi-pencil me-2"></i> <?= Yii::t('cherryii', 'Live edit') ?>
            <?= Html::checkbox('', LIVE_EDIT, [
                'data-link' => Url::to(['/admin/system/live-edit']),
                'class' => 'form-check-input ms-2'
            ]) ?>
        </span>

        <ul class="navbar-nav ms-auto">
            <li class="nav-item">
                <a class="nav-link" href="<?= Url::to(['/admin/sign/out']) ?>">
                    <i class="bi bi-box-arrow-right"></i> <?= Yii::t('cherryii', 'Logout') ?>
                </a>
            </li>
        </ul>
    </div>
</nav>