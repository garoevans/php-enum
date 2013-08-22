<?php
/**
 * @author: gareth.evans
 */
namespace Garoevans\Tests;

class EnumTest extends \PHPUnit_Framework_TestCase
{
  public function testSomething()
  {
    $this->setExpectedException(
      "UnexpectedValueException", "Enum 'non_value' does not exist"
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
      "UnexpectedValueException", "No default enum set"
    );

    new Type\EnumNoDefault();
  }

  public function testExceptionThrownWhenNoConstantsSet()
  {
    $this->setExpectedException(
      "UnexpectedValueException", "No constants set"
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
}
