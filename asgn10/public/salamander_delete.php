<?php
require_once __DIR__ . '/../private/initialize.php';

// SANDBOX EXERCISE 2
// 1. GET should load the Salamander and display its ID and common name.
// 2. Do not delete on GET.
// 3. The confirmation form should POST a hidden id back to this page.
// 4. On POST, load the Salamander again, call $salamander->delete(),
//    and redirect to salamanders.php.
// 5. Include a Cancel link that returns without changing the database.

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Delete Salamander</title>
</head>
<body>
    <h1>Delete Salamander</h1>
    <p>Complete this page during Sandbox Exercise 2.</p>
    <p><a href="salamanders.php">Back to Salamanders</a></p>
</body>
</html>
