<?php

class Bird
{
  static public  int $instance_count = 0;

  protected static  $egg_num = 0;
  var $habitat;
  var $food;
  var $nesting = "tree";
  var $conservation;
  var $song = "chirp";
  static $flying = "yes";

  public static function create() {
    $className = get_called_class();
    $obj = new $className;
    static::$instance_count++;
    return $obj;
  }

 public function can_fly() {
    return static::$flying == "yes" ? "bird can fly" : "cannot fly and it stuck on the ground";
}
}

class YellowBelliedFlyCatcher extends Bird
{
  public static $egg_num = "3-4, sometimes 5";
  var $name = "yellow-bellied flycatcher";
  var $diet = "mostly insects.";
  var $song = "flat chilk";
}

class Kiwi extends Bird
{
  var $name = "kiwi";
  var $diet = "omnivorous";
  static $flying = "no";
}
