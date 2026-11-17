<?php

require_once(__DIR__ . '/../private/initialize.php');

$_SESSION = [];
session_destroy();
header('Location: index.php');
exit;
