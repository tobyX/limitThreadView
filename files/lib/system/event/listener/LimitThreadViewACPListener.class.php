<?php
namespace wbb\system\event\listener;
use wcf\system\event\IEventListener;
use wcf\system\WCF;

/**
 * Provides ACP integration
 *
 * @author	Tobias Friebel <woltlab@tobyf.de>
 * @copyright	2014 Tobias Friebel
 * @license	Creative Commons Attribution-NonCommercial-NoDerivatives 4.0 International <http://creativecommons.org/licenses/by-nc-nd/4.0/deed.en>
 * @package	com.toby.wbb.limitthreadview
 * @subpackage	system.event.listener
 * @category	WoltLab Burning Board
 */
class LimitThreadViewACPListener implements IEventListener
{
	public $limitThreadView = 0;
	private $isSave = false;

	/**
	 * @see EventListener::execute()
	 */
	public function execute($eventObj, $className, $eventName)
	{
		switch ($eventName)
		{
			case 'readFormParameters':
				if (isset($_POST['limitThreadView'])) $this->limitThreadView = intval($_POST['limitThreadView']);
			break;

			case 'save':
				$eventObj->additionalFields['limitThreadView'] = $this->limitThreadView;
				$this->isSave = true;
			break;

			case 'assignVariables':
				if (is_object($eventObj->board) && !$this->isSave)
				{
					WCF::getTPL()->assign(array(
						'limitThreadView' => $eventObj->board->limitThreadView,
					));
				}
				else
				{
					WCF::getTPL()->assign(array(
						'limitThreadView' => $this->limitThreadView,
					));
				}
			break;
		}
	}
}
