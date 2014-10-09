<?php
/**
 * @author: gareth.evans
 */
namespace Garoevans\PhpEnum\Tests\Type;

use Garoevans\PhpEnum\Enum;

/**
 * Class EnumNoDefault
 * @package Garoevans\Tests\Type
 *
 * @method static TRUE
 * @method static FALSE
 */
class EnumNoDefault extends Enum
{
    const TRUE = "1";
    const FALSE = "0";
}
