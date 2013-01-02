<?php
if(class_exists("SplEnum"))
{
  class Enum extends SplEnum
  {
  }
}
else
{
  require_once("localenum.php");
  class Enum extends LocalEnum
  {
  }
}
