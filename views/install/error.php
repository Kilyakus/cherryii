<?php
$asset = \yii\cherryii\assets\EmptyAsset::register($this);

$this->title = Yii::t('cherryii/install', 'Installation error');
?>
<div class="container">
    <div id="wrapper" class="col-md-6 col-md-offset-3 vertical-align-parent">
        <div class="vertical-align-child">
            <div class="panel">
                <div class="panel-heading text-center">
                    <?= Yii::t('cherryii/install', 'Installation error') ?>
                </div>
                <div class="panel-body text-center">
                    <?= $error ?>
                </div>
            </div>
            <div class="text-center">
                <a class="logo" href="http://cherryiicms.com" target="_blank" title="«CherrYii» CMS homepage">
                    <img src="<?= $asset->baseUrl ?>/img/logo_20.png">«CherrYii» CMS
                </a>
            </div>
        </div>
    </div>
</div>
