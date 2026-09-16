<?php 
class Guitar {
  public string $brand; 
  public string $model;
  public float $price;

  function __construct(string $brand, string  $model, float $price) {
    $this->brand = $brand;
    $this->model = $model;
    $this->price = $price;
  }

  function summary() {
    echo "$this->brand  $this->model" .  "-"  . number_format($this->price, 2) . "<br>";
  }
}

$gibson = new Guitar('gibson', 'les-paul', 500);

$gibson->summary();

$fender = new Guitar('fender', 'strat', 600);
$fender->summary();

$original = new Guitar('ibanez', 'stratcopy', 400 );

$copy = clone $original; 

$copy ->price = 500;

$original->summary();
$copy->summary();

