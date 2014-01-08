<?php
namespace wbb\system\event\listener;
use wcf\system\event\IEventListener;
use wcf\system\WCF;

/**
 * Limits thread feeds to configured length
 *
 * @author	Tobias Friebel <woltlab@tobyf.de>
 * @copyright	2014 Tobias Friebel
 * @license	Creative Commons Attribution-NoDerivatives <http://creativecommons.org/licenses/by-nd/4.0/legalcode>
 * @package	com.toby.wbb.limitthreadview
 * @subpackage	system.event.listener
 * @category	WoltLab Burning Board
 */
class LimitThreadViewFeedListener implements IEventListener
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