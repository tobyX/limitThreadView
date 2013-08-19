<?php
/**
 * Copyright (c) 2013 Tobias Friebel
 * Authors: Tobias Friebel <TobyF@Web.de>
 *
 * Lizenz: CC Namensnennung-Keine kommerzielle Nutzung-Keine Bearbeitung
 * http://creativecommons.org/licenses/by-nc-nd/2.0/de/
 */

require_once (WCF_DIR . 'lib/system/event/EventListener.class.php');

class LimitThreadViewListener implements EventListener
{
	/**
	 * @see EventListener::execute()
	 */
	public function execute($eventObj, $className, $eventName)
	{
		if (!MODULE_LIMIT_THREAD_VIEW ||
			$eventObj->board->getPermission('canViewLimitedContent') ||
			(LIMIT_THREAD_VIEW_ALLOW_SEARCH_BOTS && WCF :: getSession()->spiderID))
			return;

		if ($eventObj->board->limitThreadView > -1)
			$limitCount = $eventObj->board->limitThreadView;
		else
			$limitCount = LIMIT_THREAD_VIEW_DEFAULT_LIMIT;

		if ($eventObj->countItems() <= $limitCount)
			return;

		switch ($eventName)
		{
			case 'readData':
				if ($eventObj->board->limitGuestView <= $eventObj->itemsPerPage)
				{
					$eventObj->pageNo = 1;
					$eventObj->itemsPerPage = $limitCount;
				}
				else
				{
					$pageMaxNo = ceil($limitCount / $eventObj->itemsPerPage);

					if ($eventObj->pageNo > $pageMaxNo)
					{
						$eventObj->pageNo = $pageMaxNo;
					}
				}
			break;

			case 'assignVariables':
				if ($limitCount <= $eventObj->itemsPerPage)
				{
					$eventObj->pages = 1;
				}
				elseif ($eventObj->countItems() > $limitCount)
				{
					$eventObj->pages = ceil($limitCount / $eventObj->itemsPerPage);

					$pageMaxNo = ceil($limitCount / $eventObj->itemsPerPage);
					$count = $limitCount - $eventObj->itemsPerPage * ($pageMaxNo - 1);

					if ($eventObj->pageNo == $pageMaxNo && $count < $eventObj->itemsPerPage)
					{
						foreach ($eventObj->postList->posts as $i => $post)
						{
							if ($i >= $count)
								unset($eventObj->postList->posts[$i]);
						}
					}
				}

				if ($eventObj->countItems() > $limitCount)
				{
					$limitBox = WCF::getLanguage()->getDynamicVariable('wbb.thread.limitthreadview',
							array('posts' => $eventObj->countItems()));

					WCF :: getTPL()->append('userMessages', $limitBox);

					if (LIMIT_THREAD_VIEW_SHOW_WARNING_DOWN)
						WCF :: getTPL()->append('additionalBoxes', $limitBox);
				}
			break;
		}
	}
}

?>