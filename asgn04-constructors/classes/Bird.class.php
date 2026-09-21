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
?>
