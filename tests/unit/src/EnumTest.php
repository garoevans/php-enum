<?php
/**
 * @author Gareth Evans <garoevans@gmail.com>
 */

namespace Garoevans\PhpEnum\Tests;

class EnumTest extends \PHPUnit_Framework_TestCase
{
    public function testInstantiatingEnumWithBadValue()
    {
        $this->setExpectedException(
            "UnexpectedValueException",
            "Enum 'non_value' does not exist"
        );

        new Type\Boolean("non_value");
    }

    public function testSetAndToString()
    {
        $enum = new Type\Boolean(Type\Boolean::TRUE);
        $this->assertEquals($enum, Type\Boolean::TRUE);
    }

    public function testExceptionThrownWhenNoDefaultSet()
    {
        $this->setExpectedException(
            "UnexpectedValueException",
            "No default enum set"
        );

        new Type\EnumNoDefault();
    }

    public function testExceptionThrownWhenNoConstantsSet()
    {
        $this->setExpectedException(
            "UnexpectedValueException",
            "No constants set"
        );

        new Type\EnumNoConstants();
    }

    public function testDefaultSetWhenNoValuePassed()
    {
        $enum = new Type\Boolean();
        $this->assertEquals($enum, Type\Boolean::__default);
    }

    public function testGetConstList()
    {
        $enum = new Type\Boolean();

        $constants = [
            "TRUE"  => "1",
            "FALSE" => "0",
        ];
        $this->assertEquals($constants, $enum->getConstList());

        $constantsWithDefault = array_merge($constants, ["__default" => "1"]);
        $this->assertEquals($constantsWithDefault, $enum->getConstList(true));
    }

    public function testCallStatic()
    {
        $enum = Type\Boolean::FALSE();
        $this->assertEquals($enum, Type\Boolean::FALSE);
    }

    public function testHasConstant()
    {
        $enum = new Type\Boolean();

        $this->assertTrue($enum->hasConstant("true"));
        $this->assertFalse($enum->hasConstant("random"));
    }

    public function testFromValue()
    {
        $this->assertEquals(Type\Boolean::TRUE(), Type\Boolean::fromValue('1'));
    }

    public function testConstFromValue()
    {
        $this->assertSame("TRUE", Type\Boolean::constFromValue('1'));
    }

    public function testBadConstFromValueThrowsException()
    {
        $this->setExpectedException(
            "UnexpectedValueException",
            "Value 'bla' does not exist"
        );

        Type\Boolean::constFromValue('bla');
    }

    public function testGetDefault()
    {
        $enum = new Type\Boolean();

        $this->assertSame(Type\Boolean::TRUE, $enum->getDefault());
    }

    public function testIs()
    {
        $enum = new Type\Boolean(Type\Boolean::TRUE);

        $this->assertTrue($enum->is(Type\Boolean::TRUE));
        $this->assertFalse($enum->is(Type\Boolean::FALSE));
    }

    /**
     * @dataProvider compareCouples
     */
    public function testMatch($shouldMatch, $val1, $val2, $strict)
    {
        if ($shouldMatch) {
            $this->assertTrue(Type\Boolean::match($val1, $val2, $strict));
        } else {
            $this->assertFalse(Type\Boolean::match($val1, $val2, $strict));
        }
    }

    public function compareCouples()
    {
        return array(
            array(true, 1, 1, true),
            array(true, new Type\Boolean(), new Type\Boolean(), true),
            array(true, new Type\Boolean(), 1, true),
            array(true, new Type\Boolean(), Type\Boolean::TRUE, true),
            array(false, 1, 2, true),
            array(false, new Type\Boolean(), new Type\Boolean(Type\Boolean::FALSE), true),
            array(false, new Type\Boolean(), 0, true),
            array(false, new Type\Boolean(), Type\Boolean::FALSE, true),
            array(true, "foo", "foo", false),
            array(false, "foo", "foo", true),
        );
    }
}
