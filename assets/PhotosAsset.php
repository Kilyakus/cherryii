<?php
namespace yii\cherryii\assets;

class PhotosAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@cherryii/assets/photos';
    public $css = [
        'photos.css',
    ];
    public $js = [
        'photos.js'
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
