<?php
// GRADED ASSIGNMENT: Build the single-bird detail page here.
// TODO: Validate ?id=..., call Bird::find_by_id(), display all seven fields,
// and handle both an invalid ID (400) and a missing bird (404).
// Use htmlspecialchars() or your existing h() helper for database text.
require_once('../private/initialize.php');

// $id = $_GET['id'] ?? '';
// 
$id = filter_input(
INPUT_GET,
'id',
FILTER_VALIDATE_INT,
['options' => ['min_range' => 1]]
);
if ($id === null || $id === false) {
  http_response_code(400);
  exit;
} 
try {
  $bird = Bird::find_by_id($id);
} catch (PDOException $e) {
    error_log($e->getMessage());
    http_response_code(500);
    exit('Sorry, something went wrong. Please try again later.');
}
if ($bird === null) {
  http_response_code(404);
}
?>
<!doctype html>
<html lang="en">
<head><meta charset="utf-8"><title>Bird Details</title></head>
<body>
    <h1>Bird Details</h1>
    <p>TODO: Display the selected bird and provide a link back to birds.php.</p>
       <p>
    <a href="birds.php">Back to directory</a>
    </p>
   <table border="1">
    <thead>
        <tr>
            <th scope="col">Common Name</th>
            <th scope="col">Scientific Name</th>
            <th scope="col">Family Name</th>
             <th scope="col">Seasonal Status</th>
            <th scope="col">Seasonal Status</th>
            <th scope="col">Description</th>
             <th scope="col">Recorded ID</th>
        </tr>
    </thead>

    <tbody>
    
    <tr>
      <td><?= h($bird->common_name)?></td>
      <td><?= h($bird->scientific_name)?></td>
      <td><?= h($bird->family_name)?></td>
      <td><?= h($bird->seasonal_status)?></td>
      <td><?= h($bird->seasonal_status)?></td>
      <td><?= h($bird->description)?></td>
      <td><?= h($bird->id)?></td>
    </tr>
    </tbody>
</table>
</body>
</html>
