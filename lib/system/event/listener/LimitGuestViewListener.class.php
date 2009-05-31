<?php
/*
 * Copyright (c) 2009 Tobias Friebel
 * Authors: Tobias Friebel <TobyF@Web.de>
 *
 * Lizenz: CC Namensnennung-Keine kommerzielle Nutzung-Keine Bearbeitung http://creativecommons.org/licenses/by-nc-nd/2.0/de/
 *
 * $Id$
 */

require_once (WCF_DIR . 'lib/system/event/EventListener.class.php');

/**
 * Limit threadview for guests
 *
 * @author Toby
 * @package	com.toby.wbb.limitguestview
 */
class LimitGuestViewListener implements EventListener
{

	/**
	 * @see EventListener::execute()
	 */
	public function execute($eventObj, $className, $eventName)
	{
		if ((WCF :: getUser()->userID != 0 && !WCF :: getUser()->activationCode) || $eventObj->board->limitGuestView == 0
			|| $eventObj->countItems() <= $eventObj->board->limitGuestView
			|| (LIMIT_GUEST_VIEW_ALLOW_SEARCH_BOTS && WCF :: getSession()->spiderID))
			return;

		switch ($eventName)
		{
			case 'readData':
				if ($eventObj->board->limitGuestView <= $eventObj->itemsPerPage)
				{
					$eventObj->pageNo = 1;
					$eventObj->itemsPerPage = $eventObj->board->limitGuestView;
				}
				else
				{
					$pageMaxNo = ceil($eventObj->board->limitGuestView / $eventObj->itemsPerPage);

					if ($eventObj->pageNo > $pageMaxNo)
					{
						$eventObj->pageNo = $pageMaxNo;
					}
				}
			break;

			case 'assignVariables':
				if ($eventObj->board->limitGuestView <= $eventObj->itemsPerPage)
				{
					$eventObj->pages = 1;
				}
				elseif ($eventObj->countItems() > $eventObj->board->limitGuestView)
				{
						$eventObj->pages = ceil($eventObj->board->limitGuestView / $eventObj->itemsPerPage);

						$pageMaxNo = ceil($eventObj->board->limitGuestView / $eventObj->itemsPerPage);
						$count = $eventObj->board->limitGuestView - $eventObj->itemsPerPage * ($pageMaxNo - 1);

						if ($eventObj->pageNo == $pageMaxNo && $count < $eventObj->itemsPerPage)
						{
							foreach ($eventObj->postList->posts as $i => $post)
							{
								if ($i >= $count)
									unset($eventObj->postList->posts[$i]);
							}
						}
				}

				if ($eventObj->countItems() > $eventObj->board->limitGuestView)
				{
					WCF :: getTPL()->assign('limitGuestView', $eventObj->countItems());
					WCF :: getTPL()->append('userMessages', WCF :: getTPL()->fetch('limitGuestViewThread'));

					if (LIMIT_GUEST_VIEW_SHOW_WARNING_DOWN)
						WCF :: getTPL()->append('additionalBoxes', WCF :: getTPL()->fetch('limitGuestViewThread'));
				}
			break;
		}
	}
}

?>