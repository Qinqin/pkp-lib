<?php
/**
 * @file controllers/api/file/linkAction/FileLinkAction.inc.php
 *
 * Copyright (c) 2003-2013 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class FileLinkAction
 * @ingroup controllers_api_file_linkAction
 *
 * @brief An abstract file action.
 */

import('lib.pkp.classes.linkAction.LinkAction');

class FileLinkAction extends LinkAction {

	/**
	 * Constructor
	 * @see LinkAction::LinkAction()
	 */
	function FileLinkAction($id, &$actionRequest, $title = null, $image = null, $tooltip = null) {
		parent::LinkAction($id, $actionRequest, $title, $image, $tooltip);
	}


	//
	// Protected helper function
	//
	/**
	 * Return the action arguments to address a file.
	 * @param $submissionFile SubmissionFile
	 * @param $stageId int (optional)
	 * @return array
	 */
	function getActionArgs(&$submissionFile, $stageId = null) {
		assert(is_a($submissionFile, 'SubmissionFile'));

		// Create the action arguments array.
		$args =  array(
			'fileId' => $submissionFile->getFileId(),
			'revision' => $submissionFile->getRevision(),
			'submissionId' => $submissionFile->getSubmissionId()
		);
		if ($stageId) $args['stageId'] = $stageId;

		return $args;
	}
}

?>
