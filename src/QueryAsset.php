<?php
/**
 * @link https://craftcms.com/
 * @copyright Copyright (c) Pixel & Tonic, Inc.
 * @license MIT
 */

namespace craft\query;

use Craft;
use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;
use craft\web\View;

/**
 * QueryAsset class.
 *
 * @author Pixel & Tonic, Inc. <support@pixelandtonic.com>
 * @since 2.0
 */
class QueryAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        // define the path that your publishable resources live
        $this->sourcePath = '@craft/query/assets';

        // define the dependencies
        $this->depends = [
            CpAsset::class,
        ];

        $this->js = [
            'query.min.js',
        ];

        // Craft 6 doesn’t load the legacy control panel styles the utility relies on
        if (self::isCraft6()) {
            $this->css = [
                'query-craft6.css',
            ];
        }

        parent::init();
    }

    /**
     * Returns whether this is Craft 6, running the plugin through the `craftcms/yii2-adapter` package.
     */
    public static function isCraft6(): bool
    {
        return version_compare(Craft::$app->getVersion(), '6.0.0-alpha', '>=');
    }

    /**
     * @inheritdoc
     */
    public function registerAssetFiles($view)
    {
        parent::registerAssetFiles($view);

        if ($view instanceof View) {
            $view->registerTranslations('query', [
                '1 result:',
                '{num} results:',
            ]);
        }
    }
}
