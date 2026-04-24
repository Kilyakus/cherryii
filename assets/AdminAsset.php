<?php
namespace yii\cherryii\assets;

class AdminAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@cherryii/media';
    public $css = [
        'css/admin.css',
    ];
    public $js = [
        'js/admin.js'
    ];
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap5\BootstrapAsset',
        'yii\cherryii\assets\SwitcherAsset',
    ];
    public $jsOptions = array(
        'position' => \yii\web\View::POS_HEAD
    );
}
