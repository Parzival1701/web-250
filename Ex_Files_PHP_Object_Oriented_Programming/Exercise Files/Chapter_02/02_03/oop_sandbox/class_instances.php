<?php

class Student {

}

class Andy {
public string $name;
  public int $age;
  public string $coolness;
  public string $stinky = 'no';
}

$me = new Andy;
$me-> name = 'The ultimate Andy';
$me-> age = 29; 
$me-> coolness = 'very'; 
$me-> stinky = 'no'; 

foreach ($me as $key => $value) {
    // Convert boolean to readable text for the echo

    
    echo $key . ": " . $value . "<br>";
}

$student1 = new Student;
$student2 = new Student;

echo get_class($student1) . "<br />";

$class_names = ['Product', 'Student', 'student'];
foreach($class_names as $class_name) {
  if(is_a($student1, $class_name)) {
    echo "student1 is a {$class_name}.<br />";
  } else {
    echo "student1 is not a {$class_name}.<br />";
  }
}

?>
