<?php

/**
 * @file controllers/grid/settings/submissionChecklist/SubmissionChecklistGridRow.inc.php
 *
 * Copyright (c) 2000-2013 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class SubmissionChecklistGridRow
 * @ingroup controllers_grid_settings_submissionChecklist
 *
 * @brief Handle submissionChecklist grid row requests.
 */

import('lib.pkp.classes.controllers.grid.GridRow');

class SubmissionChecklistGridRow extends GridRow {
	/**
	 * Constructor
	 */
	function SubmissionChecklistGridRow() {
		parent::GridRow();
	}

	//
	// Overridden template methods
	//
	/*
	 * Configure the grid row
	 * @param $request PKPRequest
	 */
	function initialize(&$request) {
		parent::initialize($request);

		// Is this a new row or an existing row?
		$rowId = $this->getId();
		if (isset($rowId) && is_numeric($rowId)) {
			$router =& $request->getRouter();
			$actionArgs = array(
				'gridId' => $this->getGridId(),
				'rowId' => $rowId
			);

			import('lib.pkp.classes.linkAction.request.AjaxModal');
			$this->addAction(
				new LinkAction(
					'editSubmissionChecklist',
					new AjaxModal(
						$router->url($request, null, null, 'editItem', null, $actionArgs),
						__('grid.action.edit'),
						'modal_edit',
						true),
					__('grid.action.edit'),
					'edit')
			);

			import('lib.pkp.classes.linkAction.request.RemoteActionConfirmationModal');
			$this->addAction(
				new LinkAction(
					'deleteSubmissionChecklist',
					new RemoteActionConfirmationModal(
						__('common.confirmDelete'),
						__('grid.action.delete'),
						$router->url($request, null, null, 'deleteItem', null, $actionArgs),
						'modal_delete'),
					__('grid.action.delete'),
					'delete')
			);
		}
	}
}

?>
