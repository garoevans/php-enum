<?php
/**
 * @author Gareth Evans <garoevans@gmail.com>
 */

namespace Garoevans\PhpEnum\Tests\Type;

use Garoevans\PhpEnum\Enum;

class EnumNoConstants extends Enum
{
    const __default = "1";
}
