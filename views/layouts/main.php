<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\cherryii\assets\AdminAsset;

$asset = AdminAsset::register($this);
$moduleName = $this->context->module->id;
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Yii::t('cherryii', 'Control Panel') ?> - <?= Html::encode($this->title) ?></title>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=latin,cyrillic' rel='stylesheet' type='text/css'>
    <link rel="shortcut icon" href="<?= $asset->baseUrl ?>/favicon.ico" type="image/x-icon">
    <link rel="icon" href="<?= $asset->baseUrl ?>/favicon.ico" type="image/x-icon">
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<div id="admin-body">
    <div class="wrapper">
        <div class="header clearfix">
            <div class="logo">
                <img src="<?= $asset->baseUrl ?>/img/logo_20.png">
                «CherrYii» CMS
            </div>
            <div class="nav px-3">
                <a href="<?= Url::to(['/']) ?>" class="float-start text-decoration-none">
                    <i class="bi bi-house"></i> <?= Yii::t('cherryii', 'Open site') ?>
                </a>
                <a href="<?= Url::to(['/admin/sign/out']) ?>" class="float-end text-decoration-none">
                    <i class="bi bi-box-arrow-right"></i> <?= Yii::t('cherryii', 'Logout') ?>
                </a>
            </div>
        </div>
        <div class="main-container d-flex">
            <div class="sidebar flex-shrink-0">
                <?php foreach(Yii::$app->getModule('admin')->activeModules as $module) : ?>
                    <a href="<?= Url::to(["/admin/$module->name"]) ?>" class="menu-item <?= ($moduleName == $module->name ? 'active' : '') ?>">
                        <?php if($module->icon != '') : ?>
                            <i class="bi bi-<?= $module->icon ?>"></i>
                        <?php endif; ?>
                        <?= $module->title ?>
                        <?php if($module->notice > 0) : ?>
                            <span class="badge rounded-pill bg-light text-dark"><?= $module->notice ?></span>
                        <?php endif; ?>
                    </a>
                <?php endforeach; ?>
                <a href="<?= Url::to(['/admin/settings']) ?>" class="menu-item <?= ($moduleName == 'admin' && $this->context->id == 'settings') ? 'active' :'' ?>">
                    <i class="bi bi-gear"></i>
                    <?= Yii::t('cherryii', 'Settings') ?>
                </a>
                <?php if(IS_ROOT) : ?>
                    <a href="<?= Url::to(['/admin/modules']) ?>" class="menu-item <?= ($moduleName == 'admin' && $this->context->id == 'modules') ? 'active' :'' ?>">
                        <i class="bi bi-folder"></i>
                        <?= Yii::t('cherryii', 'Modules') ?>
                    </a>
                    <a href="<?= Url::to(['/admin/admins']) ?>" class="menu-item <?= ($moduleName == 'admin' && $this->context->id == 'admins') ? 'active' :'' ?>">
                        <i class="bi bi-people"></i>
                        <?= Yii::t('cherryii', 'Admins') ?>
                    </a>
                    <a href="<?= Url::to(['/admin/system']) ?>" class="menu-item <?= ($moduleName == 'admin' && $this->context->id == 'system') ? 'active' :'' ?>">
                        <i class="bi bi-hdd-network"></i>
                        <?= Yii::t('cherryii', 'System') ?>
                    </a>
                    <a href="<?= Url::to(['/admin/logs']) ?>" class="menu-item <?= ($moduleName == 'admin' && $this->context->id == 'logs') ? 'active' :'' ?>">
                        <i class="bi bi-list-check"></i>
                        <?= Yii::t('cherryii', 'Logs') ?>
                    </a>
                <?php endif; ?>
            </div>
            <div class="content w-100">
                <div class="page-title">
                    <?= $this->title ?>
                </div>
                <div class="container-fluid py-4">
                    <?php foreach(Yii::$app->session->getAllFlashes() as $key => $message) : ?>
                        <div class="alert alert-<?= $key ?> alert-dismissible fade show" role="alert">
                            <?= $message ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endforeach; ?>
                    <?= $content ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>