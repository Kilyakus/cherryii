<?php
namespace yii\cherryii\assets;

class FrontendAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@cherryii/media';
    public $css = [
        'css/frontend.css',
    ];
    public $js = [
        'js/frontend.js'
    ];
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\cherryii\assets\SwitcherAsset'
    ];
}
