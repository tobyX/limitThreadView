<?php
/**
 * Copyright (c) 2013 Tobias Friebel
 * Authors: Tobias Friebel <TobyF@Web.de>
 *
 * Lizenz: CC Namensnennung-Keine kommerzielle Nutzung-Keine Bearbeitung
 * http://creativecommons.org/licenses/by-nc-nd/2.0/de/
 */

require_once(WCF_DIR.'lib/system/event/EventListener.class.php');

class LimitThreadViewACPListener implements EventListener
{
	private $limitThreadView = 0;
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

				WCF::getTPL()->append('additionalFields', WCF::getTPL()->fetch('limitThreadView'));
			break;
		}
	}
}
