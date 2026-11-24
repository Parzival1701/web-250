<?php
// GET displays the Create form; a successful POST inserts a new bird.
// Initialize before output so session handling and later redirects can work.
require_once dirname(__DIR__) . '/private/initialize.php';
require_member(); // Protect BOTH the form (GET) and the INSERT (POST).

// This object supplies the shared form's values: initially empty, then the
// submitted values if validation fails and the user needs to correct them.
$bird = new Bird();
$errors = [];
if (is_post_request()) {
    // Check the submitted form token against this session before accepting changes.
    require_valid_csrf();
    // Collect and trim the form values. Missing fields become empty strings.
    $bird->common_name = trim((string) ($_POST['common_name'] ?? ''));
    $bird->scientific_name = trim((string) ($_POST['scientific_name'] ?? ''));
    $bird->family_name = trim((string) ($_POST['family_name'] ?? ''));
    $bird->primary_habitat = trim((string) ($_POST['primary_habitat'] ?? ''));
    $bird->seasonal_status = trim((string) ($_POST['seasonal_status'] ?? ''));
    $bird->description = trim((string) ($_POST['description'] ?? ''));
    // Validate on the server too; browser required/maxlength rules can be bypassed.
    $errors = bird_form_errors($bird);
    if (!$errors) {
        try {
            // The object sends its properties to the Bird class's INSERT method.
            $bird->create();
            // Redirect to a fresh GET so refreshing does not repeat the INSERT.
            // redirect_to() also exits, preventing this form from rendering afterward.
            redirect_to('birds.php');
        } catch (PDOException $exception) {
            // Keep database details in the server log; show a useful message below.
            error_log($exception->getMessage());
            $errors[] = 'The bird could not be saved. Check your database configuration.';
        }
    }
}
?>
<!doctype html>
<html lang="en"><head><meta charset="utf-8"><title>Create Bird</title></head><body>
<?php require __DIR__ . '/nav.php'; ?>
<h1>Create a Bird</h1>
<?php print_errors($errors); ?>
<form method="post">
    <input type="hidden" name="csrf_token" value="<?php print h(csrf_token()); ?>">
    <?php require __DIR__ . '/bird_fields.php'; ?>
    <button type="submit">Create Bird</button>
</form>
<p><a href="birds.php">Cancel</a></p>
</body></html>
