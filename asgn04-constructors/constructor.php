<?php
class Bird {
  public string $commonName;
  public string $latinName;

  public function __construct(string $commonName, string $latinName) {
    $this->commonName = $commonName;
    $this->latinName = $latinName;
  }

  public function summary() {
    echo "Common name: " . $this->commonName . "<br>";
    echo "Latin name: " . $this->latinName . "<br>";
    echo "<hr>";
  }
}

$b1 = new Bird('Robin', 'Turdus migratorius');
$b2 = new Bird('Estern Towhee','Pipilo erythrophthalmus');

$b1->summary();
$b2->summary();
