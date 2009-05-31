<?php
/*
 * Copyright (c) 2009 Tobias Friebel
 * Authors: Tobias Friebel <TobyF@Web.de>
 *
 * Lizenz: CC Namensnennung-Keine kommerzielle Nutzung-Keine Bearbeitung http://creativecommons.org/licenses/by-nc-nd/2.0/de/
 *
 * $Id$
 */

require_once(WCF_DIR.'lib/system/event/EventListener.class.php');

/**
 * Add/Edit LimitGuestView
 *
 * @author	Toby
 * @package	com.toby.wbb.limitguestview
 */
class LimitGuestViewACPListener implements EventListener
{
	private $limitGuestView = 0;
	private $isSave = false;

	/**
	 * @see EventListener::execute()
	 */
	public function execute($eventObj, $className, $eventName)
	{
		switch ($eventName)
		{
			case 'readFormParameters':
				if (isset($_POST['limitGuestView'])) $this->limitGuestView = abs(intval($_POST['limitGuestView']));
			break;

			case 'save':
				$eventObj->additionalFields['limitGuestView'] = $this->limitGuestView;
				$this->isSave = true;
			break;

			case 'assignVariables':
				if (is_object($eventObj->board) && !$this->isSave)
				{
					WCF::getTPL()->assign(array(
						'limitGuestView' => $eventObj->board->limitGuestView,
					));
				}
				else
				{
					WCF::getTPL()->assign(array(
						'limitGuestView' => $this->limitGuestView,
					));
				}

				WCF::getTPL()->append('additionalFields', WCF::getTPL()->fetch('limitGuestView'));
			break;
		}
	}
}
?>