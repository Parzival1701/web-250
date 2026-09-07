<?php

class Student {

  var $first_name;
  var $last_name;
  var $country = 'None';

  public function say_hello() {
    return(" hello world!");
  }
}

$student1 = new Student;
$student1->first_name = 'Lucy';
$student1->last_name = 'Ricardo';

$student2 = new Student;
$student2->first_name = 'Ethel';
$student2->last_name = 'Mertz';

echo $student1->first_name . " " . $student1->last_name . "<br />";
echo $student2->first_name . " " . $student2->last_name . "<br />";

$class_methods = get_class_methods('Student');
echo "Class methods:" . implode(',',$class_methods) . "<br>";



if(method_exists('Student', 'say_hello')) {
  echo "method say_hello() exists in Student class.<br />";
} else {
  echo "method say_hello() does not exists in Student class.<br />";}


echo $student1->say_hello();
echo '<pre>';
print_r(get_class_methods($student1));
echo '</pre>';
 