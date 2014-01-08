<?php
namespace wbb\system\event\listener;
use wcf\system\event\IEventListener;
use wcf\system\WCF;

/**
 * Limits thread to configured length
 *
 * @author	Tobias Friebel <woltlab@tobyf.de>
 * @copyright	2014 Tobias Friebel
 * @license	Creative Commons Attribution-NoDerivatives <http://creativecommons.org/licenses/by-nd/4.0/legalcode>
 * @package	com.toby.wbb.limitthreadview
 * @subpackage	system.event.listener
 * @category	WoltLab Burning Board
 */
class LimitThreadViewListener implements IEventListener
{
	/**
	 * @see	\wcf\system\event\IEventListener::execute()
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
				if ($eventObj->countItems() <= $limitCount)
					return;

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
						foreach ($eventObj->objectList as $i => $post)
						{
							if ($i >= $count)
								unset($eventObj->objectList[$i]);
						}
					}
				}

				if ($eventObj->countItems() > $limitCount)
				{
					$limitBox = WCF::getLanguage()->getDynamicVariable('wbb.thread.limitthreadview',
							array('posts' => $eventObj->countItems()));

					WCF :: getTPL()->assign('limitMessageBox', $limitBox);
				}
			break;
		}
	}
}

?>