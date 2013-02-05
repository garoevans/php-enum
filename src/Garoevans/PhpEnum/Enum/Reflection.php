<?php
/**
 * @author: gareth.evans
 */

namespace Garoevans\PhpEnum\Enum;

abstract class Reflection
{
  protected $_default;
  protected $_enum;
  protected $_enums = array();
  protected $_enumsReversed = array();

  protected static $_defaultKey = "__default";


  /**
   * @param mixed $enum
   * @param bool  $strict
   */
  public function __construct($enum = null, $strict = false)
  {
    $reflection = new \ReflectionClass($this);
    $constants  = $reflection->getConstants();

    $this->_setDefault($constants)
      ->_setEnums($constants)
      ->_setEnum($enum);
  }

  /**
   * @param array $constants
   *
   * @return Reflection $this
   * @throws \UnexpectedValueException
   */
  protected function _setDefault(array $constants)
  {
    if(!isset($constants[self::$_defaultKey]))
    {
      throw new \UnexpectedValueException("No default enum set");
    }

    $this->_default = $constants[self::$_defaultKey];

    return $this;
  }

  /**
   * @param array $constants
   *
   * @return Reflection $this
   * @throws \UnexpectedValueException
   */
  protected function _setEnums(array $constants)
  {
    $tempConstants = $constants;

    if(\array_key_exists(self::$_defaultKey, $tempConstants))
    {
      unset($tempConstants[self::$_defaultKey]);
    }

    if(empty($tempConstants))
    {
      throw new \UnexpectedValueException("No constants set");
    }

    $this->_enums = $tempConstants;
    $this->_enumsReversed = \array_flip($this->_enums);

    return $this;
  }

  /**
   * @param $enum
   *
   * @return Reflection $this
   * @throws \UnexpectedValueException
   */
  protected function _setEnum($enum)
  {
    if($enum === null)
    {
      $enum = $this->_default;
    }

    if(!\array_key_exists($enum, $this->_enumsReversed))
    {
      throw new \UnexpectedValueException("Enum '{$enum}' does not exist");
    }

    $this->_enum = $enum;

    return $this;
  }

  public function __toString()
  {
    return (string)$this->_enum;
  }

  /**
   * @param bool $includeDefault
   *
   * @return array
   */
  public function getConstList($includeDefault = false)
  {
    $constants = $this->_enums;

    if($includeDefault)
    {
      $constants = array_merge(
        array(self::$_defaultKey => $this->_default), $constants
      );
    }

    return $constants;
  }
}
