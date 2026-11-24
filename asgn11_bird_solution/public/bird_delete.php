<?php
// Visiting this page asks for confirmation; submitting its form performs deletion.
require_once dirname(__DIR__) . '/private/initialize.php';
require_member(); // A GET can only show confirmation; only POST can delete.
// Validate the URL ID before the lookup. Bad or missing input receives 400.
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!is_int($id) || $id <= 0) {
    http_response_code(400);
    exit('Invalid bird ID.');
}
// Load the record so the confirmation can show its actual name and ID.
$bird = Bird::find_by_id($id);
if ($bird === null) {
    // This ID is a valid number, but no matching record exists: return 404.
    http_response_code(404);
    exit('Bird not found.');
}
$errors = [];
if (is_post_request()) {
    // A valid session token is required as well as membership before deleting.
    require_valid_csrf();
    try {
        $bird->delete();
        // Return to the directory with a fresh GET and stop this request.
        // Refreshing the directory will not repeat the deletion submission.
        redirect_to('birds.php');
    } catch (PDOException $exception) {
        // Keep the confirmation page and show a message for a database error.
        error_log($exception->getMessage());
        $errors[] = 'Could not delete this bird.';
    }
}
// The confirmation escapes the bird's name with h(); Cancel only follows a link.
?>
<!doctype html>
<html lang="en"><head><meta charset="utf-8"><title>Delete Bird</title></head><body>
<?php require __DIR__ . '/nav.php'; ?>
<h1>Delete Bird</h1>
<?php print_errors($errors); ?>
<p>Are you sure you want to delete ID <?php print $id; ?>:
<strong><?php print h($bird->common_name); ?></strong>?</p>
<form method="post">
    <input type="hidden" name="csrf_token" value="<?php print h(csrf_token()); ?>">
    <button type="submit">Yes, delete bird</button>
</form>
<p><a href="birds.php">Cancel</a></p>
</body></html>
