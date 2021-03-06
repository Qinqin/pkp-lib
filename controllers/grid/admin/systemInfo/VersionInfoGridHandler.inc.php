<?php

/**
 * @file controllers/grid/admin/systemInfo/VersionInfoGridHandler.inc.php
 *
 * Copyright (c) 2000-2013 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class VersionInfoGridHandler
 * @ingroup controllers_grid_admin_systemInfo
 *
 * @brief Handle version info grid requests.
 */

import('lib.pkp.classes.controllers.grid.GridHandler');
import('lib.pkp.controllers.grid.admin.systemInfo.InfoGridCellProvider');


class VersionInfoGridHandler extends GridHandler {
	/**
	 * Constructor
	 */
	function VersionInfoGridHandler() {
		parent::GridHandler();
		$this->addRoleAssignment(array(
			ROLE_ID_SITE_ADMIN),
			array('fetchGrid', 'fetchRow')
		);
	}


	//
	// Implement template methods from PKPHandler.
	//
	/**
	 * @see PKPHandler::authorize()
	 */
	function authorize(&$request, &$args, $roleAssignments) {
		import('lib.pkp.classes.security.authorization.PolicySet');
		$rolePolicy = new PolicySet(COMBINING_PERMIT_OVERRIDES);

		import('lib.pkp.classes.security.authorization.RoleBasedHandlerOperationPolicy');
		foreach($roleAssignments as $role => $operations) {
			$rolePolicy->addPolicy(new RoleBasedHandlerOperationPolicy($request, $role, $operations));
		}
		$this->addPolicy($rolePolicy);

		return parent::authorize($request, $args, $roleAssignments);
	}

	/**
	 * @see PKPHandler::initialize()
	 */
	function initialize(&$request) {
		parent::initialize($request);

		// Load user-related translations.
		AppLocale::requireComponents(
			LOCALE_COMPONENT_PKP_USER,
			LOCALE_COMPONENT_PKP_ADMIN,
			LOCALE_COMPONENT_APP_ADMIN,
			LOCALE_COMPONENT_APP_MANAGER,
			LOCALE_COMPONENT_APP_COMMON
		);

		// Basic grid configuration.
		$this->setTitle('admin.versionHistory');

		//
		// Grid columns.
		//
		$infoGridCellProvider = new InfoGridCellProvider();

		// Version number.
		$this->addColumn(
			new GridColumn(
				'version',
				'admin.version',
				null,
				'controllers/grid/gridCell.tpl',
				$infoGridCellProvider,
				array('width' => 20)
			)
		);

		// major version number.
		$this->addColumn(
			new GridColumn(
				'versionMajor',
				'admin.versionMajor',
				null,
				'controllers/grid/gridCell.tpl',
				$infoGridCellProvider
			)
		);

		// minor version number.
		$this->addColumn(
			new GridColumn(
				'versionMinor',
				'admin.versionMinor',
				null,
				'controllers/grid/gridCell.tpl',
				$infoGridCellProvider
			)
		);

		// revision version number.
		$this->addColumn(
			new GridColumn(
				'versionRevision',
				'admin.versionRevision',
				null,
				'controllers/grid/gridCell.tpl',
				$infoGridCellProvider
			)
		);

		// build version number.
		$this->addColumn(
			new GridColumn(
				'versionBuild',
				'admin.versionBuild',
				null,
				'controllers/grid/gridCell.tpl',
				$infoGridCellProvider
			)
		);

		// installation date
		$this->addColumn(
			new GridColumn(
				'dateInstalled',
				'admin.dateInstalled',
				null,
				'controllers/grid/gridCell.tpl',
				$infoGridCellProvider
			)
		);
	}


	//
	// Implement template methods from GridHandler
	//

	/**
	 * @see GridHandler::loadData
	 */
	function loadData(&$request, $filter) {
		$versionDao = DAORegistry::getDAO('VersionDAO');
		return $versionDao->getVersionHistory();
	}
}
?>
