<?php

namespace craft\query;

use Craft;
use craft\events\ResolveResourcePathEvent;
use craft\services\Resources;
use craft\events\RegisterComponentTypesEvent;
use craft\events\RegisterUrlRulesEvent;
use craft\services\Utilities;
use craft\web\UrlManager;
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
        Event::on(Resources::class, Resources::EVENT_RESOLVE_RESOURCE_PATH, function(ResolveResourcePathEvent $event){
            if ($event->uri === 'foo/bar'){
                $event->path = \Craft::getAlias('????????');

                $event->handled = true;
            }

        });
       Event::on(Utilities::class, Utilities::EVENT_REGISTER_UTILITY_TYPES, [$this, 'registerUtility']);
    }

    public function registerUtility(RegisterComponentTypesEvent $event)
    {
        $event->types[] = Utility::class;

    }
}