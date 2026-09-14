<?php

class Bird
{
  static public $instance_count;

  static public $egg_num = 0;
  var $habitat;
  var $food;
  var $nesting = "tree";
  var $conservation;
  var $song = "chirp";
  var $flying = "yes";

  public static function create() {}

  public function can_fly()
  {
    if (static::$flying == "yes") {
      $flying_string = "bird can fly";
    } else {
      $flying_string = "cannot fly and it stuck on the ground";
    }
    return $flying_string;
  }
}

class YellowBelliedFlyCatcher extends Bird
{
  
  var $name = "yellow-bellied flycatcher";
  var $diet = "mostly insects.";
  var $song = "flat chilk";
}
 
class Kiwi extends Bird
{
  var $name = "kiwi";
  var $diet = "omnivorous";
  var $flying = "no";
}
