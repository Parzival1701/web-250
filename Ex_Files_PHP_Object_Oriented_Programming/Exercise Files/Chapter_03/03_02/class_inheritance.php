<?php

class User {

  var $first_name;
  var $last_name;
  var $username;
  var $is_admin = false;

  function full_name() {
    return $this->first_name . " " . $this->last_name;
  }
}

class adminUser extends User {
  var $is_admin = true;

   function full_name() {
    return $this->first_name . " " . $this->last_name . " (Admin";
  }
}

class Customer extends User {
  var $city;
  var $state;
  var $country;

  function location() {
    return $this->city . ", " .  $this->state . ", " . $this->country; 
  }
}

$u = new user;
$u->first_name = 'jerry';
$u->last_name = 'seinfeld';
$u->username = 'jseinfeld';

$c = new customer;
$c->first_name = 'george';
$c->last_name = 'castanza';
$c->username = 'gcostanza';
$c->city = 'New york';
$c->state = 'New york';
$c->country = 'United States';


echo $u->full_name() . '<br>';
echo $c->full_name() . '<br>';
echo $c->location() . '<br>';

echo get_parent_class($u) . '<br>';
echo get_parent_class($c) . '<br>';

if(is_subclass_of($c, 'User')) {
  echo 'instance is a subclass of user. <br>';
}

$parents = class_parents($c);
echo implode(', ',$parents) . '<br>';

?>
