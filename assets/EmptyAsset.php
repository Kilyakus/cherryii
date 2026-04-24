<?php
namespace yii\cherryii\assets;

class EmptyAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@cherryii/media';
    public $css = [
        'css/empty.css',
    ];
    public $depends = [
        'yii\bootstrap5\BootstrapAsset',
    ];
}
