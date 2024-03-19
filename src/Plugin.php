<?php
/**
 * @link https://craftcms.com/
 * @copyright Copyright (c) Pixel & Tonic, Inc.
 * @license MIT
 */

namespace craft\query;

use craft\events\RegisterComponentTypesEvent;
use craft\services\Utilities;
use yii\base\Event;

/**
 * Query plugin.
 *
 * @author Pixel & Tonic, Inc. <support@pixelandtonic.com>
 * @since 2.0
 */
class Plugin extends \craft\base\Plugin
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // Register our query utility.
        $eventName = defined(sprintf('%s::EVENT_REGISTER_UTILITY_TYPES', Utilities::class))
            ? Utilities::EVENT_REGISTER_UTILITY_TYPES // Craft 4
            /** @phpstan-ignore-next-line */
            : Utilities::EVENT_REGISTER_UTILITIES; // Craft 5+

        Event::on(
            Utilities::class,
            $eventName,
            function(RegisterComponentTypesEvent $event) {
                $event->types[] = Utility::class;
            }
        );
    }
}
