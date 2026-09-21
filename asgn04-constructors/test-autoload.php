<?php
require_once __DIR__ . '/autoload.php';
spl_autoload_register('my_autoload');
$flycatcher = new Bird([
  "commonName" => "Acadian Flycatcher",
  "latinName" => "Empidonax virescens"
]);

$flycatcher->summary();
