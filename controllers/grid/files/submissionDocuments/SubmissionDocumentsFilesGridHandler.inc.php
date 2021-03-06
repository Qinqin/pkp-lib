<?php

/**
 * @file controllers/grid/files/submissionDocuments/SubmissionDocumentsFilesGridHandler.inc.php
 *
 * Copyright (c) 2003-2013 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class LibraryFileGridHandler
 * @ingroup controllers_grid_files_submissionDocuments
 *
 * @brief Handle submission documents file grid requests.
 */

import('lib.pkp.controllers.grid.files.LibraryFileGridHandler');
import('controllers.grid.files.submissionDocuments.SubmissionDocumentsFilesGridDataProvider');

class SubmissionDocumentsFilesGridHandler extends LibraryFileGridHandler {
	/**
	 * Constructor
	 */
	function SubmissionDocumentsFilesGridHandler() {

		parent::LibraryFileGridHandler(new SubmissionDocumentsFilesGridDataProvider());
		$this->addRoleAssignment(
			array(ROLE_ID_MANAGER, ROLE_ID_SUB_EDITOR, ROLE_ID_ASSISTANT, ROLE_ID_AUTHOR),
			array(
				'addFile', 'uploadFile', 'saveFile', // Adding new library files
				'editFile', 'updateFile', // Editing existing library files
				'deleteFile', 'viewLibrary'
			)
		);
	}


	//
	// Overridden template methods
	//

	/*
	 * Configure the grid
	 * @param $request PKPRequest
	 */
	function initialize(&$request) {
		$this->setCanEdit(true); // this grid can always be edited.
		parent::initialize($request);

		AppLocale::requireComponents(LOCALE_COMPONENT_APP_EDITOR);

		// Set instructions
		$this->setInstructions('editor.submissionLibrary.description');

		$router =& $request->getRouter();

		// Add grid-level actions

		if ($this->canEdit()) {
			$this->addAction(
				new LinkAction(
					'addFile',
					new AjaxModal(
						$router->url($request, null, null, 'addFile', null, $this->getActionArgs()),
						__('grid.action.addFile'),
						'modal_add_file'
					),
					__('grid.action.addFile'),
					'add'
				)
			);
		}

		$this->addAction(
			new LinkAction(
				'viewLibrary',
				new AjaxModal(
					$router->url($request, null, null, 'viewLibrary', null, $this->getActionArgs()),
					__('grid.action.viewLibrary'),
					'modal_information'
				),
				__('grid.action.viewLibrary'),
				'more_info'
			)
		);

	}

	/**
	 * Retrieve the arguments for the 'add file' action.
	 * @return array
	 */
	function getActionArgs() {
		$submission =& $this->getAuthorizedContextObject(ASSOC_TYPE_SUBMISSION);
		$actionArgs = array(
			'submissionId' => $submission->getId(),
		);

		return $actionArgs;
	}

	/**
	 * Get the row handler - override the default row handler
	 * @return LibraryFileGridRow
	 */
	function &getRowInstance() {
		$submission =& $this->getAuthorizedContextObject(ASSOC_TYPE_SUBMISSION);
		$row = new LibraryFileGridRow($this->canEdit(), $submission);
		return $row;
	}

	//
	// Public File Grid Actions
	//

	/**
	 * Load the (read only) press file library.
	 * @param $args array
	 * @param $request PKPRequest
	 * @return string Serialized JSON object
	 */
	function viewLibrary($args, &$request) {

		$templateMgr =& TemplateManager::getManager($request);
		$templateMgr->assign('canEdit', false);
		return $templateMgr->fetchJson('controllers/tab/settings/library.tpl');
	}

	/**
	 * Returns a specific instance of the new form for this grid.
	 * @param $context Press
	 * @return NewLibraryFileForm
	 */
	function &_getNewFileForm($context) {
		$submission =& $this->getAuthorizedContextObject(ASSOC_TYPE_SUBMISSION);
		import('lib.pkp.controllers.grid.files.submissionDocuments.form.NewLibraryFileForm');
		$fileForm = new NewLibraryFileForm($context->getId(), $submission->getId());
		return $fileForm;
	}

	/**
	 * Returns a specific instance of the edit form for this grid.
	 * @param $context Press
	 * @param $fileId int
	 * @return EditLibraryFileForm
	 */
	function &_getEditFileForm($context, $fileId) {
		$submission =& $this->getAuthorizedContextObject(ASSOC_TYPE_SUBMISSION);
		import('lib.pkp.controllers.grid.files.submissionDocuments.form.EditLibraryFileForm');
		$fileForm = new EditLibraryFileForm($context->getId(), $fileId, $submission->getId());
		return $fileForm;
	}
}

?>
