<?php
namespace Craft;

/**
 * Query plugin class
 */
class QueryPlugin extends BasePlugin
{
	public function getName()
	{
		return 'Query';
	}

	public function getVersion()
	{
		return '0.1';
	}

	public function getDeveloper()
	{
		return 'Pixel & Tonic';
	}

	public function getDeveloperUrl()
	{
		return 'http://pixelandtonic.com/';
	}

	public function hasCpSection()
	{
		if (craft()->userSession->isAdmin())
		{
			return true;
		}
	}
}
