<?php

/**
 * @file controllers/tab/settings/announcements/form/AnnouncementSettingsForm.inc.php
 *
 * Copyright (c) 2003-2013 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class AnnouncementSettingsForm
 * @ingroup controllers_tab_settings_announcements_form
 *
 * @brief Form to edit announcement settings.
 */

import('lib.pkp.classes.controllers.tab.settings.form.ContextSettingsForm');

class AnnouncementSettingsForm extends ContextSettingsForm {

	/**
	 * Constructor.
	 */
	function AnnouncementSettingsForm($wizardMode = false) {
		$settings = array(
			'enableAnnouncements' => 'bool',
			'enableAnnouncementsHomepage' => 'bool',
			'numAnnouncementsHomepage' => 'int',
			'announcementsIntroduction' => 'string',
		);

		parent::ContextSettingsForm($settings, 'controllers/tab/settings/announcements/form/announcementSettingsForm.tpl', $wizardMode);
	}


	//
	// Implement template methods from Form.
	//
	/**
	 * @see Form::getLocaleFieldNames()
	 */
	function getLocaleFieldNames() {
		return array('announcementsIntroduction');
	}


	//
	// Implement template methods from ContextSettingsForm.
	//
	/**
	 * @see ContextSettingsForm::fetch()
	 */
	function fetch(&$request) {
		for($x = 1; $x < 11; $x++) {
			$numAnnouncementsHomepageOptions[$x] = $x;
		}

		$params = array(
			'numAnnouncementsHomepageOptions' => $numAnnouncementsHomepageOptions,
			'disableAnnouncementsHomepage' => !$this->getData('enableAnnouncementsHomepage')
		);

		return parent::fetch($request, $params);
	}
}

?>
