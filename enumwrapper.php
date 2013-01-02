<?php
if(class_exists("SplEnum"))
{
  class EnumWrapper extends SplEnum
  {
  }
}
else
{
  require_once("localenum.php");
  class EnumWrapper extends LocalEnum
  {
  }
}

class Enum extends EnumWrapper
{
}
