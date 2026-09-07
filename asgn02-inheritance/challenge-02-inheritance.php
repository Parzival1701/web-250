<?php
class mini
{
  protected  string $name = 'mini';
  protected int $creationDate;
  private $color = 'red';
  public function fullName()
  {
    return $this->name .  "<br>";
  }

  public function setDate($value) {
    $this->creationDate = $value;
  }

  public function getDate() {
    return $this->creationDate . "<br>";
  }

  public function colorChange($value) {
    $this->color = $value;
  }
}

class cooper extends mini
{
  protected string $tuning = 'cooper';
  public function fullName()
  {
    return $this->name . $this->tuning .  "<br>";
  }
}

class cooperS extends cooper
{
  private $trim = 's';
  public function fullName()
  {
    return $this->name . $this->tuning . " " . $this->trim .  "<br>";
  }
}

$m = new mini;
$m->setDate(1959);
echo 'This is a ' .$m->fullName();
echo 'from' .$m->getDate();

$c = new cooper;
$c->colorChange('british racing green');
$c->setDate(1961);
echo 'This is a ' . $c->fullName();
echo 'from' . $c->getDate();

$cs = new cooperS;
$cs->colorChange('yellow');
$cs->setDate(2001);
echo 'This is a' . $cs->fullName();
echo 'from' . $cs->getDate();
