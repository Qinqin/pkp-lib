<?php

/**
 * @defgroup pages_submission
 */

/**
 * @file pages/submission/index.php
 *
 * Copyright (c) 2003-2013 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @ingroup pages_submission
 * @brief Handle requests for the submission wizard.
 *
 */

switch ($op) {
	//
	// PKP Submission
	//
	case 'fetchChoices':
		import('lib.pkp.pages.submission.PKPSubmissionHandler');
		define('HANDLER_CLASS', 'PKPSubmissionHandler');
		break;
}

?>
