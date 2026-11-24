<?php
// Edit an existing bird: GET fills the form; POST validates and saves changes.
require_once dirname(__DIR__) . '/private/initialize.php';
require_member(); // Prevent direct-URL update as well as unauthorized POST.
// A missing, noninteger, or nonpositive URL ID is a bad request (400).
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!is_int($id) || $id <= 0) {
    http_response_code(400);
    exit('Invalid bird ID.');
}
// Load the object before showing the shared fields, so the form is prefilled.
// Its ID stays attached to the object when the submitted properties are replaced.
$bird = Bird::find_by_id($id);
if ($bird === null) {
    // A well-formed ID with no matching database record is not found (404).
    http_response_code(404);
    exit('Bird not found.');
}
$errors = [];
if (is_post_request()) {
    // Verify the form belongs to this session before processing the requested update.
    require_valid_csrf();
    // Replace the editable properties with submitted values. If validation fails,
    // these same values remain in the form so the user can correct them.
    $bird->common_name = trim((string) ($_POST['common_name'] ?? ''));
    $bird->scientific_name = trim((string) ($_POST['scientific_name'] ?? ''));
    $bird->family_name = trim((string) ($_POST['family_name'] ?? ''));
    $bird->primary_habitat = trim((string) ($_POST['primary_habitat'] ?? ''));
    $bird->seasonal_status = trim((string) ($_POST['seasonal_status'] ?? ''));
    $bird->description = trim((string) ($_POST['description'] ?? ''));
    // Server validation must pass before the UPDATE method is called.
    $errors = bird_form_errors($bird);
    if (!$errors) {
        try {
            $bird->update();
            // Display the saved record through a fresh GET; the helper exits here.
            // Refreshing that details page will not submit the update again.
            redirect_to('bird.php?id=' . $id);
        } catch (PDOException $exception) {
            // Log the technical details without exposing them in the browser.
            error_log($exception->getMessage());
            $errors[] = 'The bird could not be updated.';
        }
    }
}
?>
<!doctype html>
<html lang="en"><head><meta charset="utf-8"><title>Update Bird</title></head><body>
<?php require __DIR__ . '/nav.php'; ?>
<h1>Update Bird #<?php print $id; ?></h1>
<?php print_errors($errors); ?>
<form method="post">
    <input type="hidden" name="csrf_token" value="<?php print h(csrf_token()); ?>">
    <?php require __DIR__ . '/bird_fields.php'; ?>
    <button type="submit">Update Bird</button>
</form>
<p><a href="birds.php">Cancel</a></p>
</body></html>
