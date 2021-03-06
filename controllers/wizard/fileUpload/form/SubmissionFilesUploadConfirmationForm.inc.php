<?php

/**
 * @file controllers/wizard/fileUpload/form/SubmissionFilesUploadConfirmationForm.inc.php
 *
 * Copyright (c) 2003-2013 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class SubmissionFilesUploadConfirmationForm
 * @ingroup controllers_wizard_fileUpload_form
 *
 * @brief Form for adding/editing a submission file
 */


import('controllers.wizard.fileUpload.form.SubmissionFilesUploadBaseForm');

class SubmissionFilesUploadConfirmationForm extends SubmissionFilesUploadBaseForm {
	/**
	 * Constructor.
	 * @param $request Request
	 * @param $submissionId integer
	 * @param $stageId integer One of the WORKFLOW_STAGE_ID_* constants.
	 * @param $fileStage integer
	 * @param $revisedFileId integer
	 * @param $uploadedFile integer
	 */
	function SubmissionFilesUploadConfirmationForm(&$request, $submissionId, $stageId, $fileStage,
			&$reviewRound, $revisedFileId = null, $assocType = null, $assocId = null, $uploadedFile = null) {

		// Initialize class.
		parent::SubmissionFilesUploadBaseForm(
			$request, 'controllers/wizard/fileUpload/form/fileUploadConfirmationForm.tpl',
			$submissionId, $stageId, $fileStage, false, $reviewRound, $revisedFileId, $assocType, $assocId
		);

		if (is_a($uploadedFile, 'SubmissionFile')) {
			$this->setData('uploadedFile', $uploadedFile);
		}
	}


	//
	// Implement template methods from Form
	//
	/**
	 * @see Form::readInputData()
	 */
	function readInputData() {
		$this->readUserVars(array('uploadedFileId'));
		return parent::readInputData();
	}

	/**
	 * @see Form::execute()
	 * @param $request Request
	 * @return SubmissionFile if successful, otherwise null
	 */
	function &execute(&$request) {
		// Retrieve the file ids of the revised and the uploaded files.
		$revisedFileId = $this->getRevisedFileId();
		$uploadedFileId = (int)$this->getData('uploadedFileId');
		if (!($revisedFileId && $uploadedFileId)) fatalError('Invalid file ids!');
		if ($revisedFileId == $uploadedFileId) fatalError('The revised file id and the uploaded file id cannot be the same!');

		// Assign the new file as the latest revision of the old file.
		$submissionFileDao = DAORegistry::getDAO('SubmissionFileDAO'); /* @var $submissionFileDao SubmissionFileDAO */
		$submissionId = $this->getData('submissionId');
		$fileStage = $this->getData('fileStage');
		$uploadedFile =& $submissionFileDao->setAsLatestRevision($revisedFileId, $uploadedFileId, $submissionId, $fileStage);

		return $uploadedFile;
	}
}

?>
