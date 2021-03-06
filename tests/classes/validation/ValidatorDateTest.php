<?php

/**
 * @file tests/classes/validation/ValidatorDateTest.inc.php
 *
 * Copyright (c) 2000-2013 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class ValidatorDateTest
 * @ingroup tests_classes_validation
 * @see ValidatorDate
 *
 * @brief Test class for ValidatorDate.
 */

import('lib.pkp.tests.PKPTestCase');
import('lib.pkp.classes.validation.ValidatorDate');

class ValidatorDateTest extends PKPTestCase {
	/**
	 * @covers ValidatorDate
	 * @covers ValidatorRegExp
	 */
	public function testValidatorDate() {
		$validator = new ValidatorDate();
		self::assertTrue($validator->isValid('2010-05-14'));
		self::assertTrue($validator->isValid('2010-05'));
		self::assertTrue($validator->isValid('2010'));
		self::assertFalse($validator->isValid(''));
		self::assertFalse($validator->isValid('2010-00'));
		self::assertFalse($validator->isValid('2010-13'));
		self::assertFalse($validator->isValid('2010-05-00'));
		self::assertFalse($validator->isValid('2010-04-31'));
		self::assertTrue($validator->isValid('2008-02-29'));
		self::assertFalse($validator->isValid('2009-02-29'));
		self::assertFalse($validator->isValid('anything else'));
	}
}
?>
