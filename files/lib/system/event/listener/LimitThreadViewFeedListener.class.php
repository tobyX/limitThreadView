<?php
/**
 * Copyright (c) 2013 Tobias Friebel
 * Authors: Tobias Friebel <TobyF@Web.de>
 *
 * Lizenz: CC Namensnennung-Keine kommerzielle Nutzung-Keine Bearbeitung
 * http://creativecommons.org/licenses/by-nc-nd/2.0/de/
 */

require_once(WCF_DIR.'lib/system/event/EventListener.class.php');

class LimitThreadViewFeedListener implements EventListener
{
	/**
	 * @see EventListener::execute()
	 */
	public function execute($eventObj, $className, $eventName)
	{
		if (!MODULE_LIMIT_THREAD_VIEW || !MODULE_LIMIT_THREAD_FEEDS ||
			(LIMIT_THREAD_VIEW_ALLOW_SEARCH_BOTS && WCF :: getSession()->spiderID))
			return;

		$eventObj->limit = LIMIT_THREAD_VIEW_DEFAULT_LIMIT;
	}
}