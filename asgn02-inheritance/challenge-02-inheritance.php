<?php
class mini
{
  var  string $name = 'mini';
  var int $creationDate;
  function fullName()
  {
    return $this->name .  "<br>";
  }
}

class cooper extends mini
{
  var string $tuning = 'cooper';
  function fullName()
  {
    return $this->name . $this->tuning .  "<br>";
  }
}

class cooperS extends cooper
{
  var $trim = 's';
  function fullName()
  {
    return $this->name . $this->tuning . " " . $this->trim .  "<br>";
  }
}

$m = new mini;
$m->creationDate = 1959;
echo $m->fullName();

$c = new cooper;
$c->creationDate = 1961;
echo $c->fullName();

$cs = new cooperS;
$cs->creationDate = 2001;
echo $cs->fullName();
