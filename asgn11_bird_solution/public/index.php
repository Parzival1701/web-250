<?php
// Every public page starts here so its classes, database, session, and helpers exist.
require_once dirname(__DIR__) . '/private/initialize.php';

// Ask Bird for the count instead of putting database SQL in the display page.
// This page is public, so no member-only guard is needed for this read operation.
$bird_count = Bird::count_all();

// The shared navigation chooses visitor or signed-in links. The count below
// is printed as an integer because the page expects a number, not HTML text.
?>
<!doctype html>
<html lang="en"><head><meta charset="utf-8"><title>WNC Birds</title></head><body>
<?php require __DIR__ . '/nav.php'; ?>
<h1>Western North Carolina Birds</h1>
<p>Our database currently includes <?php print (int) $bird_count; ?> birds.</p>
<p><a href="birds.php">View the bird directory</a></p>
<p>Visitors can read about birds. Signed-in members can create, update, and delete them.</p>
</body></html>
