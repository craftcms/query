<?php
namespace craft\query;

use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;

class QueryAsset extends AssetBundle
{
    public function init()
    {
        // define the path that your publishable resources live
        $this->sourcePath = '@craft/query/assets';


        // define the relative path to CSS/JS files that should be registered with the page
        // when this asset bundle is registered

        // define the dependencies
        $this->depends = [
            CpAsset::class,
        ];

        $this->js = [
            'query.js',
        ];

        parent::init();
    }
}
