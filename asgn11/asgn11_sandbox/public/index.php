<?php
require_once __DIR__ . '/../private/initialize.php';
echo '<pre>';
print_r($_SESSION);
echo '</pre>';
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>WEB 250 - Salamander CRUD Sandbox</title>
</head>

<body>
  <h1>Salamander CRUD Sandbox</h1>
  <p><a href="salamanders.php">Open Salamander Table</a></p>
  <a href="logout.php">Logout</a>
</body>

</html>
