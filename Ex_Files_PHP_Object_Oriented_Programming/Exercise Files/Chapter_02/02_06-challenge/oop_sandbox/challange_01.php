<?php
class bicycle {
  public  $brand;
  public  $model;
  public  $year;
  public  $description;
  public  $weight_kg;

  public function name() {
    echo("this is a {$this->brand} bike, that is the {$this->model} model from {$this->year}");
  }

   public function weight_ibs() {
    $answer = $this->weight_kg * 2.2046226218;
    return $answer;
  }

   public function set_weight_ibs($value) {
    $this->weight_kg = $value / 2.2046226218; 
  }
}

$bike1 = new bicycle; 
$bike1->brand = 'huffy';
$bike1->model = 'huff monster';
$bike1->year = 1991;
$bike1->description = 'a rad bike ';
$bike1->weight_kg = 100;

$bike2 = new bicycle; 
$bike2->brand = 'schwinn';
$bike2->model = 'big bike';
$bike2->year = 2006;
$bike2->description = 'a even more rad bike';
$bike2->weight_kg = 30;

echo $bike1->name(). "<br>";
echo $bike1->weight_ibs(). "<br>";
echo $bike1->set_weight_ibs(200). "<br>";
echo $bike1->weight_ibs(). "<br>";







