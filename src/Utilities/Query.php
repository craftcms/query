<?php

declare(strict_types=1);

namespace CraftCms\Query\Utilities;

use CraftCms\Cms\Support\Html;
use CraftCms\Cms\Utility\Utility;
use Override;

use function CraftCms\Cms\t;

/**
 * Query utility for executing database queries in the control panel.
 *
 * @since 2.0
 */
class Query extends Utility
{
    #[Override]
    public static function displayName(): string
    {
        return t('Query', category: 'query');
    }

    #[Override]
    public static function id(): string
    {
        return 'query';
    }

    #[Override]
    public static function icon(): string
    {
        return 'database';
    }

    #[Override]
    public static function contentHtml(): string
    {
        return Html::tag('QueryUtility');
    }
}
