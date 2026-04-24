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
<body class="vh-100 overflow-hidden d-flex flex-column bg-black">
<?php $this->beginBody() ?>

<div id="dynamic-background"></div>

<div class="app-container d-flex flex-column h-100 w-100 position-relative">
    
    <header class="glass-panel d-flex justify-content-between align-items-center px-4" 
            style="min-height: 70px; border-top:0; border-right:0; border-left:0; border-radius:0;">
        <div class="d-flex align-items-center gap-3">
            <img src="<?= $asset->baseUrl ?>/img/logo_20.png" alt="Logo">
            <h1 class="m-0 fs-5 uppercase-text fw-bold tracking-wider text-white">«CherrYii» CMS</h1>
        </div>

        <div class="d-flex align-items-center gap-4">
            <a href="<?= Url::to(['/']) ?>" class="text-decoration-none text-white opacity-75 custom-hover">
                <i class="bi bi-house"></i> <?= Yii::t('cherryii', 'Open site') ?>
            </a>
            <a href="<?= Url::to(['/admin/sign/out']) ?>" class="text-decoration-none text-white opacity-75 custom-hover">
                <i class="bi bi-box-arrow-right"></i> <?= Yii::t('cherryii', 'Logout') ?>
            </a>
        </div>
    </header>

    <main class="flex-grow-1 overflow-hidden d-flex px-4 gap-4">
        
        <aside id="sidebar" class="h-100 py-4" style="width: 280px; min-width: 280px;">
            <div class="sidebar-inner glass-panel h-100 d-flex flex-column overflow-hidden">
                <div class="flex-grow-1 overflow-y-auto p-3 d-flex flex-column gap-2" id="categories-scroll-area">
                    
                    <?php foreach(Yii::$app->getModule('admin')->activeModules as $module) : ?>
                        <a href="<?= Url::to(["/admin/$module->name"]) ?>" 
                           class="menu-item text-white text-decoration-none p-2 rounded d-flex align-items-center <?= ($moduleName == $module->name ? 'bg-primary bg-opacity-25 border border-primary' : '') ?>">
                            <?php if($module->icon != '') : ?>
                                <i class="bi bi-<?= $module->icon ?> me-2 opacity-75"></i>
                            <?php endif; ?>
                            <span class="flex-grow-1"><?= $module->title ?></span>
                            <?php if($module->notice > 0) : ?>
                                <span class="badge rounded-pill bg-light text-dark ms-2"><?= $module->notice ?></span>
                            <?php endif; ?>
                        </a>
                    <?php endforeach; ?>
                    
                    <hr class="border-secondary opacity-25 my-2">
                    
                    <a href="<?= Url::to(['/admin/settings']) ?>" 
                       class="menu-item text-white text-decoration-none p-2 rounded d-flex align-items-center <?= ($moduleName == 'admin' && $this->context->id == 'settings') ? 'bg-primary bg-opacity-25 border border-primary' :'' ?>">
                        <i class="bi bi-gear me-2 opacity-75"></i>
                        <span class="flex-grow-1"><?= Yii::t('cherryii', 'Settings') ?></span>
                    </a>
                    
                    <?php if(IS_ROOT) : ?>
                        <a href="<?= Url::to(['/admin/modules']) ?>" 
                           class="menu-item text-white text-decoration-none p-2 rounded d-flex align-items-center <?= ($moduleName == 'admin' && $this->context->id == 'modules') ? 'bg-primary bg-opacity-25 border border-primary' :'' ?>">
                            <i class="bi bi-folder me-2 opacity-75"></i>
                            <span class="flex-grow-1"><?= Yii::t('cherryii', 'Modules') ?></span>
                        </a>
                        <a href="<?= Url::to(['/admin/admins']) ?>" 
                           class="menu-item text-white text-decoration-none p-2 rounded d-flex align-items-center <?= ($moduleName == 'admin' && $this->context->id == 'admins') ? 'bg-primary bg-opacity-25 border border-primary' :'' ?>">
                            <i class="bi bi-people me-2 opacity-75"></i>
                            <span class="flex-grow-1"><?= Yii::t('cherryii', 'Admins') ?></span>
                        </a>
                        <a href="<?= Url::to(['/admin/system']) ?>" 
                           class="menu-item text-white text-decoration-none p-2 rounded d-flex align-items-center <?= ($moduleName == 'admin' && $this->context->id == 'system') ? 'bg-primary bg-opacity-25 border border-primary' :'' ?>">
                            <i class="bi bi-hdd-network me-2 opacity-75"></i>
                            <span class="flex-grow-1"><?= Yii::t('cherryii', 'System') ?></span>
                        </a>
                        <a href="<?= Url::to(['/admin/logs']) ?>" 
                           class="menu-item text-white text-decoration-none p-2 rounded d-flex align-items-center <?= ($moduleName == 'admin' && $this->context->id == 'logs') ? 'bg-primary bg-opacity-25 border border-primary' :'' ?>">
                            <i class="bi bi-list-check me-2 opacity-75"></i>
                            <span class="flex-grow-1"><?= Yii::t('cherryii', 'Logs') ?></span>
                        </a>
                    <?php endif; ?>

                </div>
            </div>
        </aside>

        <section id="content" class="flex-grow-1 h-100 overflow-hidden">
            <div id="file-list-container" class="h-100 overflow-y-auto py-4">
                
                <div class="glass-panel p-4 min-vh-100">
                    <h2 class="text-white mb-4 fw-light opacity-75"><?= Html::encode($this->title) ?></h2>
                    
                    <?php foreach(Yii::$app->session->getAllFlashes() as $key => $message) : ?>
                        <div class="alert alert-<?= $key ?> alert-dismissible fade show shadow-sm" role="alert">
                            <?= $message ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endforeach; ?>
                    
                    <div class="text-white">
                        <?= $content ?>
                    </div>
                </div>

            </div>
        </section>
    </main>

</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>