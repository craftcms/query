<?php

declare(strict_types=1);

namespace CraftCms\Query;

use CraftCms\Cms\Plugin\Plugin as BasePlugin;
use CraftCms\Cms\Utility\Utility;
use CraftCms\Query\Utilities\Query;

/**
 * Query plugin.
 *
 * @since 2.0
 */
class Plugin extends BasePlugin
{
    /** @var array<class-string<Utility>> */
    protected array $utilities = [
        Query::class,
    ];

    /**
     * The Query utility’s Vue component.
     */
    protected array $vite = [
        'resources/js/cp.js',
    ];
}
