<?php

namespace DevGroup\GridUtils\assets;

use yii\bootstrap\BootstrapPluginAsset;
use yii\web\AssetBundle;
use yii\web\JqueryAsset;

class GridUtilsBundle extends AssetBundle
{
    public $depends = [
        JqueryAsset::class,
    ];

    public function init()
    {
        $this->sourcePath = __DIR__ . '/dist/';

        $this->js = [
            YII_ENV_DEV ? 'grid-utils.bundle.js' : 'grid-utils.bundle.min.js'
        ];

        $this->css = [
            YII_ENV_DEV ? 'grid-utils.bundle.css' : 'grid-utils.bundle.min.css'
        ];

        parent::init();
    }
}
