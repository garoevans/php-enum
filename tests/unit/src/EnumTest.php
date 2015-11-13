<?php
/**
 * @author: gareth.evans
 */
namespace Garoevans\PhpEnum\Tests;

class EnumTest extends \PHPUnit_Framework_TestCase
{
    public function testSomething()
    {
        $this->setExpectedException(
            "UnexpectedValueException",
            "Enum 'non_value' does not exist"
        );

        new Type\Bool("non_value");
    }

    public function testSetAndToString()
    {
        $enum = new Type\Bool(Type\Bool::TRUE);
        $this->assertEquals($enum, Type\Bool::TRUE);
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
        $enum = new Type\Bool();
        $this->assertEquals($enum, Type\Bool::__default);
    }

    public function testGetConstList()
    {
        $enum = new Type\Bool();

        $constants = [
            "TRUE"  => "1",
            "FALSE" => "0"
        ];
        $this->assertEquals($constants, $enum->getConstList());

        $constantsWithDefault = array_merge($constants, ["__default" => "1"]);
        $this->assertEquals($constantsWithDefault, $enum->getConstList(true));
    }

    public function testCallStatic()
    {
        $enum = Type\Bool::FALSE();
        $this->assertEquals($enum, Type\Bool::FALSE);
    }

    public function testConstantExists()
    {
        $enum = new Type\Bool();

        $this->assertTrue($enum->constantExists("true"));
        $this->assertFalse($enum->constantExists("random"));
    }

    public function testFromValue()
    {
        $this->assertEquals(Type\Bool::TRUE(), Type\Bool::fromValue('1'));
    }

    public function testConstFromValue()
    {
        $this->assertSame("TRUE", Type\Bool::constFromValue('1'));
    }

    public function testBadConstFromValueThrowsException()
    {
        $this->setExpectedException(
            "UnexpectedValueException",
            "Value 'bla' does not exist"
        );

        Type\Bool::constFromValue('bla');
    }

    public function testGetDefault()
    {
        $enum = new Type\Bool();

        $this->assertSame(Type\Bool::TRUE, $enum->getDefault());
    }

    public function testIs()
    {
        $enum = new Type\Bool(Type\Bool::TRUE);

        $this->assertTrue($enum->is(Type\Bool::TRUE));
        $this->assertFalse($enum->is(Type\Bool::FALSE));
    }

    /**
     * @dataProvider compareCouples
     */
    public function testMatch($shouldMatch, $val1, $val2, $strict)
    {
        if ($shouldMatch) {
            $this->assertTrue(Type\Bool::match($val1, $val2, $strict));
        } else {
            $this->assertFalse(Type\Bool::match($val1, $val2, $strict));
        }
    }

    public function compareCouples()
    {
        return array(
            array(true, 1, 1, true),
            array(true, new Type\Bool(), new Type\Bool(), true),
            array(true, new Type\Bool(), 1, true),
            array(true, new Type\Bool(), Type\Bool::TRUE, true),
            array(false, 1, 2, true),
            array(false, new Type\Bool(), new Type\Bool(Type\Bool::FALSE), true),
            array(false, new Type\Bool(), 0, true),
            array(false, new Type\Bool(), Type\Bool::FALSE, true),
            array(true, "foo", "foo", false),
            array(false, "foo", "foo", true),
        );
    }
}
