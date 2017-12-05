<?php
/**
 * @link      https://craftcms.com/
 * @copyright Copyright (c) Pixel & Tonic, Inc.
 * @license   MIT
 */

namespace craft\query;

use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;

/**
 * QueryAsset class.
 *
 * @author Pixel & Tonic, Inc. <support@pixelandtonic.com>
 * @since  2.0
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
            'query'.$this->dotJs(),
        ];

        parent::init();
    }
}
