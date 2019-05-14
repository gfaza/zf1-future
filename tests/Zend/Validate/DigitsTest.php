<?php
/**
 * Zend Framework
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://framework.zend.com/license/new-bsd
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@zend.com so we can send you a copy immediately.
 *
 * @category   Zend
 * @package    Zend_Validate
 * @subpackage UnitTests
 * @copyright  Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 * @version    $Id$
 */

/**
 * @see Zend_Validate_Digits
 */
require_once 'Zend/Validate/Digits.php';


/**
 * @category   Zend
 * @package    Zend_Validate
 * @subpackage UnitTests
 * @copyright  Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 * @group      Zend_Validate
 */
class Zend_Validate_DigitsTest extends PHPUnit_Framework_TestCase
{
    /**
     * Zend_Validate_Digits object
     *
     * @var Zend_Validate_Digits
     */
    protected $_validator;

    /**
     * Creates a new Zend_Validate_Digits object for each test method
     *
     * @return void
     */
    public function setUp()
    {
        $this->_validator = new Zend_Validate_Digits();
    }

    /**
     * Ensures that the validator follows expected behavior for basic input values
     *
     * @return void
     */
    public function testExpectedResultsWithBasicInputValues()
    {
        trigger_error("PHP 7.2 Compatibility Alert ERROR: The behaviour of hexadecimal numeric strings was inconsistent prior to PHP 7 and support has been removed in PHP 7.".sprintf(" (%s::%s)", __FILE__, __LINE__) . "\n\t" . implode("\n\t", array_map(function ($item) { return call_user_func_array('sprintf', array_values(array_merge(array('format' => '%s::%s %s%s%s'), array_fill_keys(array('file', 'line', 'class', 'type', 'function'), null), $item))); }, debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS))), E_USER_WARNING);
        $valuesExpected = array(
            'abc123'  => false,
            'abc 123' => false,
            'abcxyz'  => false,
            'AZ@#4.3' => false,
            '1.23'    => false,
            '0x9f'    => false,
            '123'     => true,
            '09'      => true,
            ''        => false
            );
        foreach ($valuesExpected as $input => $result) {
            $this->assertEquals($result, $this->_validator->isValid($input));
        }
    }

    /**
     * Ensures that getMessages() returns expected initial value
     *
     * @return void
     */
    public function testMessagesEmptyInitially()
    {
        $this->assertEquals(array(), $this->_validator->getMessages());
    }

    /**
     * @return void
     */
    public function testEmptyStringValueResultsInProperValidationFailureMessages()
    {
        $this->assertFalse($this->_validator->isValid(''));
        $messages = $this->_validator->getMessages();
        $arrayExpected = array(
            Zend_Validate_Digits::STRING_EMPTY => '\'\' is an empty string'
            );
        $this->assertThat($messages, $this->identicalTo($arrayExpected));
    }

    /**
     * @return void
     * @deprecated Since 1.5.0
     */
    public function testEmptyStringValueResultsInProperValidationFailureErrors()
    {
        $this->assertFalse($this->_validator->isValid(''));
        $errors = $this->_validator->getErrors();
        $arrayExpected = array(
            Zend_Validate_Digits::STRING_EMPTY
            );
        $this->assertThat($errors, $this->identicalTo($arrayExpected));
    }

    /**
     * @return void
     */
    public function testInvalidValueResultsInProperValidationFailureMessages()
    {
        $this->assertFalse($this->_validator->isValid('#'));
        $messages = $this->_validator->getMessages();
        $arrayExpected = array(
            Zend_Validate_Digits::NOT_DIGITS => '\'#\' must contain only digits'
            );
        $this->assertThat($messages, $this->identicalTo($arrayExpected));
    }

    /**
     * @return void
     * @deprecated Since 1.5.0
     */
    public function testInvalidValueResultsInProperValidationFailureErrors()
    {
        $this->assertFalse($this->_validator->isValid('#'));
        $errors = $this->_validator->getErrors();
        $arrayExpected = array(
            Zend_Validate_Digits::NOT_DIGITS
            );
        $this->assertThat($errors, $this->identicalTo($arrayExpected));
    }

    /**
     * @ZF-4352
     */
    public function testNonStringValidation()
    {
        $this->assertFalse($this->_validator->isValid(array(1 => 1)));
    }
}
