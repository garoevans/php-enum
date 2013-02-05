<?php
/**
 * @author: gareth.evans
 */
namespace Garoevans\Tests\Type;

use Garoevans\PhpEnum\Enum;

class Bool extends Enum
{
  const __default = self::TRUE;

  const TRUE = "1";
  const FALSE = "0";
}
