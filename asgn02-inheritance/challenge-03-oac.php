<?php 

class Bicycle {

  public $brand;
  public $model;
  public $year;
  public $description = 'Used bicycle';
  private $weight_kg = 0.0;
  protected $wheels = 2;

  public function wheel_details() {
    $wheel_string = $this->wheels == 1 ? "1 wheel" : "{$this->wheels} wheels";
    return "It has " . $wheel_string . ".";
  }

  public function name() {
    return $this->brand . " " . $this->model . " (" . $this->year . ")";
  }

  public function weight_lbs() {
    $weight_lbs = floatval($this->weight_kg) * 2.2046226218;
    return $weight_lbs . " lbs";
  }

  public function set_weight_lbs($value) {
    $this->weight_kg = floatval($value) / 2.2046226218;
  }

  public function setWeightKg($value) {
    $this->weight_kg = floatval($value);
  }

  public function WeightKg() {
    return $this->weight_kg . ' kg';
  }
}

class unicycle extends bicycle {
  protected $wheels = 1;
}

$uni = new unicycle;
$uni->brand = 'huffy';


$trek = new Bicycle;
$trek->brand = 'Trek';
$trek->model = 'Emonda';
$trek->year = '2017';
$trek->setWeightKg(1.0) ;


echo $trek->name() . "<br />";

echo " bike weight" . $trek->weightKg() . "<br />";
echo "bike weight" . $trek->weight_lbs() . "<br />";

echo "Bicycle: " . $trek->wheel_details() . "<br />";
echo "Unicycle: " . $uni->wheel_details() . "<br />";
?>
