<?php
/**
 * This gives us a convenient way to always have an Enum object available and
 * utilise Spl Types if available. It does kick up a bit of a fuss in some IDEs
 * as it sees two classes with the same name, but we know this isn't an issue as
 * the code is down there :)
 *
 * We also wrap the SplEnum class to stop IDEs thinking that the constructor
 * parameters are necessary.
 *
 * @author: gareth.evans
 */
namespace Garoevans\PhpEnum;

if(class_exists("\\SplEnum"))
{
  class SplWrapper extends \SplEnum
  {
    public function __construct($enum = null, $strict = false)
    {
      parent::__construct($enum, $strict);
    }
  }

  abstract class EnumWrapper extends SplWrapper
  {

  }
}
else
{
  abstract class EnumWrapper extends Enum\Reflection
  {

  }
}

/**
 * @method Enum __toString()
 * @method Enum getConstList()
 */
abstract class Enum extends EnumWrapper
{
  public static function __callStatic($name, $arguments)
  {
    return new static(constant(get_called_class() . '::' . strtoupper($name)));
  }

  public function constantExists($constant)
  {
    return array_key_exists(strtoupper($constant), $this->getConstList());
  }
}
