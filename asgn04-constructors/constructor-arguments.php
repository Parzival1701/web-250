<?php 
class Bird {
  public string $commonName;
  public string $latinName;

  public function __construct($args = []) {
    $this->commonName = $args['commonName'] ?? null;
    $this->latinName = $args['latinName'] ?? null;
  }

   public function summary() {
    $commonName = $this->commonName ?? "unKnown common name";
    $latinName = $this->latinName ?? "UnKnown latin Name";

    echo "common name: " . $commonName . "<br>";
    echo "latin name: " . $latinName . "<hr>";
   }
}


$b1 = new Bird([
  "commonName" => "Acadian Flycatche",
  "latinName" => "Turdus migratorius"
]);

$b2 = new Bird([
  "commonName" => "Eastern Towhee",
  "latinName" => "Pipilo erythrophthalmus"
]);

$b1->summary();
$b2->summary();
