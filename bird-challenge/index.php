<?php

class bird
{
  public $commonName;
  public $food = "bugs";
  public $nestPlacement = "tree";
  public $conservationLevel;
  public $song;
  public $fly;

  public function song($sounds)
  {
    $this->song = $sounds;
    echo $this->song;
  }

  public function canFly($yesNoFlight)
  {
    if ($yesNoFlight == "yes") {
      $this->fly = "this bird can fly";
    } else {
      echo "this bird cannot fly";
    }
  }
}

$bird1 = new bird;
$bird1->commonName = "Eastern Towhee";
$bird1->food = "seeds, fruits, insects, spiders";
$bird1->nestPlacement = "Ground";
$bird1->conservationLevel = "Low";
$bird1->song("Drink-your-tea!");
$bird1->canFly('yes');

$bird2 = new bird;
$bird2->commonName = "Indigo Bunting";
$bird2->food = "small seeds, berries, buds, insects";
$bird2->nestPlacement = " roadsides, and railroad rights-of-wafields and on the edges";
$bird2->conservationLevel = "Low";
$bird2->song("whatwhat!!");
$bird2->canFly('yes');

echo "<pre>";
print_r($bird1);
print_r($bird2);
echo "</pre>";
