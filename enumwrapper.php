<?php
if(class_exists("SplEnum"))
{
  abstract class Enum extends SplEnum
  {
  }
}
else
{
  require_once("localenum.php");
  abstract class Enum extends LocalEnum
  {
  }
}
