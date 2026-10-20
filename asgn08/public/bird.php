<?php
// GRADED ASSIGNMENT: Build the single-bird detail page here.
// TODO: Validate ?id=..., call Bird::find_by_id(), display all seven fields,
// and handle both an invalid ID (400) and a missing bird (404).
// Use htmlspecialchars() or your existing h() helper for database text.
require_once('../private/initialize.php');
try {
    $pdo = (isset($pdo) && $pdo instanceof PDO) ? $pdo : Database::connect();
    Bird::set_database($pdo);
    $birds = Bird::find_all();
} catch (PDOException $e) {
    error_log($e->getMessage());
    http_response_code(500);
    exit('Could not load the bird sandbox. Check the database connection.');
}
$id = $_GET['id'] ?? '';
$bird = Bird::find_by_id($id);
?>
<!doctype html>
<html lang="en">
<head><meta charset="utf-8"><title>Bird Details</title></head>
<body>
    <h1>Bird Details</h1>
    <p>TODO: Display the selected bird and provide a link back to birds.php.</p>
       <p>
    <a href="index.php">Back to Home</a>
    </p>
   <table border="1">
    <thead>
        <tr>
            <th scope="col">Common Name</th>
            <th scope="col">Scientific Name</th>
            <th scope="col">Primary Habitat</th>
            <th scope="col">Seasonal Status</th>
        </tr>
    </thead>

    <tbody>
    <?php  foreach($birds as $bird) { ?>
    <tr>
      <td><?= h($bird->common_name)?></td>
      <td><?= h($bird->scientific_name)?></td>
      <td><?= h($bird->primary_habitat)?></td>
      <td><?= h($bird->seasonal_status)?></td>
    </tr>
   <?php } ?>
    </tbody>
</table>
</body>
</html>
