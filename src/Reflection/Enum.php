<?php
/**
 * @author: gareth.evans
 */

namespace Garoevans\PhpEnum\Reflection;

abstract class Enum
{
    protected $default;
    protected $enum;
    protected $enums = array();
    protected $enumsReversed = array();

    protected static $defaultKey = "__default";

    protected static $constantsCache = [];

    /**
     * @param mixed $enum
     * @param bool  $strict
     */
    public function __construct($enum = null, $strict = false)
    {
        $this->setDefault($this->getConstants())
            ->setEnums($this->getConstants())
            ->setEnum($enum);
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
     * @param array $constants
     *
     * @return Enum $this
     * @throws \UnexpectedValueException
     */
    protected function setDefault(array $constants)
    {
        if (!isset($constants[self::$defaultKey])) {
            throw new \UnexpectedValueException("No default enum set");
        }

        $this->default = $constants[self::$defaultKey];

        return $this;
    }

    /**
     * @param array $constants
     *
     * @return Enum $this
     * @throws \UnexpectedValueException
     */
    protected function setEnums(array $constants)
    {
        $tempConstants = $constants;

        if (\array_key_exists(self::$defaultKey, $tempConstants)) {
            unset($tempConstants[self::$defaultKey]);
        }

        if (empty($tempConstants)) {
            throw new \UnexpectedValueException("No constants set");
        }

        $this->enums         = $tempConstants;
        $this->enumsReversed = \array_flip($this->enums);

        return $this;
    }

    /**
     * @param $enum
     *
     * @return Enum $this
     * @throws \UnexpectedValueException
     */
    protected function setEnum($enum)
    {
        if ($enum === null) {
            $enum = $this->default;
        }

        if (!\array_key_exists($enum, $this->enumsReversed)) {
            throw new \UnexpectedValueException("Enum '{$enum}' does not exist");
        }

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
        $constants = $this->enums;

        if ($includeDefault) {
            $constants = array_merge(
                array(self::$defaultKey => $this->default),
                $constants
            );
        }

        return $constants;
    }
}
