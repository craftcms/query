<?php

namespace craft\query;

use craft\events\RegisterComponentTypesEvent;
use craft\services\Utilities;
use yii\base\Event;

/**
 * Query plugin.
 *
 * @author Pixel & Tonic, Inc. <support@pixelandtonic.com>
 * @since  2.0
 */
class Plugin extends \craft\base\Plugin
{
    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // Register our query utility.
        Event::on(Utilities::class, Utilities::EVENT_REGISTER_UTILITY_TYPES, [$this, 'registerUtility']);
    }

    /**
     * Registers the query utility.
     *
     * @param RegisterComponentTypesEvent $event
     */
    public function registerUtility(RegisterComponentTypesEvent $event)
    {
        $event->types[] = Utility::class;
    }
}
