<?php
/**
 * @author: gareth.evans
 */

namespace Garoevans\PhpEnum\Reflection;

abstract class Enum
{
    protected $enum;

    protected static $defaultKey = "__default";

    protected static $constantsCache = [];

    /**
     * @param mixed $enum
     * @param bool  $strict
     * @throws \UnexpectedValueException
     */
    public function __construct($enum = null, $strict = false)
    {
        if (!isset($this->getConstants()[static::$defaultKey])) {
            throw new \UnexpectedValueException("No default enum set");
        }

        if (count($this->getConstants()) === 1) {
            throw new \UnexpectedValueException("No constants set");
        }

        $enum = $enum !== null ? $enum : $this->getConstants()[static::$defaultKey];

        if (!in_array($enum, $this->getConstants())) {
            throw new \UnexpectedValueException("Enum '{$enum}' does not exist");
        }

        $this->setEnum($enum);
    }

    /**
     * @return array return key => value representation of the constants set in the calling class.
     */
    protected function getConstants()
    {
        $calledClass = get_called_class();
        if (!isset(static::$constantsCache[$calledClass])) {
            static::$constantsCache[$calledClass] = (new \ReflectionClass($this))->getConstants();
        }

        return static::$constantsCache[$calledClass];
    }

    /**
     * @param $enum
     *
     * @return Enum $this
     * @throws \UnexpectedValueException
     */
    protected function setEnum($enum)
    {
        $this->enum = $enum;

        return $this;
    }

    public function __toString()
    {
        return (string)$this->enum;
    }

    /**
     * @param bool $includeDefault
     *
     * @return array
     */
    public function getConstList($includeDefault = false)
    {
        if ($includeDefault) {
            return $this->getConstants();
        }

        $constants = $this->getConstants();
        unset($constants[static::$defaultKey]);

        return $constants;
    }
}
