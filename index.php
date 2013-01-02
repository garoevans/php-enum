<?php
require_once("enumwrapper.php");

class Bool extends Enum
{
  const __default = self::TRUE;

  const TRUE = "true";
  const FALSE = "false";
}

echo new Bool(Bool::TRUE) . "<br />";

try
{
  new Bool(Bool::TRUE);
  echo "All Good" . "<br />";
}
catch (UnexpectedValueException $uve)
{
  echo $uve->getMessage() . "<br />";
}

try
{
  new Bool('wrong');
  echo "It liked this one?" . "<br />";
}
catch (UnexpectedValueException $uve)
{
  echo $uve->getMessage() . "<br />";
}

print_r(new Bool(Bool::TRUE));
