<?php
// GRADED ASSIGNMENT: Build the bird directory page here.
// TODO: require private/initialize.php, get Bird::find_all(), output an
// accessible HTML table of bird names, scientific names, habitat, season,
// and links to bird.php?id=... . Escape all database-derived text.

require_once dirname(__DIR__) . '/private/initialize.php';
try {
    // Use the existing asgn07 Database connection class and credentials.
    $pdo = (isset($pdo) && $pdo instanceof PDO) ? $pdo : Database::connect();
    $birds = Bird::find_all();
} catch (PDOException $e) {
    error_log($e->getMessage());
    http_response_code(500);
    exit('Could not load the bird sandbox. Check the database connection.');
}
?>
<!doctype html>
<html lang="en">
<head><meta charset="utf-8"><title>WNC Bird Directory</title></head>
<body>
    <h1>WNC Bird Directory</h1>
    <p>TODO: Replace this paragraph with your directory table.</p>
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
            <th scope="col">View Details</th>
        </tr>
    </thead>

    <tbody>
    <?php  foreach($birds as $bird) { ?>
    <tr>
      <td><?= h($bird->common_name)?></td>
      <td><?= h($bird->scientific_name)?></td>
      <td><?= h($bird->primary_habitat)?></td>
      <td><?= h($bird->seasonal_status)?></td>
      <td><a href="bird.php?id=<?= (int) $bird->id ?>">View details</a></td>
    </tr>
   <?php } ?>
    </tbody>
</table>
</body>
</html>
