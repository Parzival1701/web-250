<?php
require_once __DIR__ . '/../private/initialize.php';

// SANDBOX EXERCISE 1
// 1. Read a positive id from GET on the first request.
// 2. Use Salamander::find_by_id() to load the selected record.
// 3. On POST, read the hidden id, load the object again, copy form values,
//    call $salamander->update(), and redirect to salamanders.php.
// 4. Reuse the field structure from salamander_new.php so the current values
//    appear in the form.

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Update Salamander</title>
</head>
<body>
    <h1>Update Salamander</h1>
    <p>Complete this page during Sandbox Exercise 1.</p>
    <p><a href="salamanders.php">Back to Salamanders</a></p>
</body>
</html>
