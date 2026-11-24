<?php
// Load the session, database, classes, and helpers before sending HTML.
// Registration may redirect the browser, so its processing belongs first.
require_once dirname(__DIR__) . '/private/initialize.php';

// An existing login does not need a second registration form.
// redirect_to() sends the new address and stops this request.
if (is_logged_in()) {
    redirect_to('birds.php');
}

// On the first visit, these provide empty form values and no error messages.
// After a failed submission, the same object keeps the values for redisplay.
$member = new Member();
$errors = [];

// GET displays the form; POST processes the values submitted by that form.
if (is_post_request()) {
    // Check the submitted token against this session before handling a write.
    require_valid_csrf();

    // Missing fields become empty strings. trim() removes accidental outer spaces
    // from account details; the password is left unchanged because spaces may matter.
    $member->first_name = trim((string) ($_POST['first_name'] ?? ''));
    $member->last_name = trim((string) ($_POST['last_name'] ?? ''));
    $member->email = trim((string) ($_POST['email'] ?? ''));
    $member->username = trim((string) ($_POST['username'] ?? ''));
    $password = (string) ($_POST['password'] ?? '');

    // Public registration always creates a member, regardless of any posted role.
    // The create() method also enforces this rule when it inserts the record.
    $member->role = 'member';

    // Collect field and duplicate-account errors before attempting an INSERT.
    // The password check is separate because the object will store only its hash.
    $errors = $member->validation_errors();
    if (strlen($password) < 8) {
        $errors[] = 'Password must contain at least 8 characters.';
    }

    if (!$errors) {
        try {
            // Hash the new password once, then let Member handle the database SQL.
            $member->set_password($password);
            $member->create(); // Guarantees a new public account has role 'member'.

            // Registration does not log the person in. This flag lets login.php
            // display a success message before asking for their credentials.
            redirect_to('login.php?registered=1');
        } catch (PDOException $exception) {
            // Keep database details in the server log; show a useful form message.
            error_log('Member registration: ' . $exception->getMessage());
            $errors[] = 'Registration could not be completed. Try another email or username.';
        }
    }
}

// Below, h() escapes values when they are placed back into HTML attributes.
// The hidden token supports the next POST check; the password is never refilled.
?>
<!doctype html>
<html lang="en"><head><meta charset="utf-8"><title>Register</title></head><body>
<?php require __DIR__ . '/nav.php'; ?>
<h1>Register as a Member</h1>
<?php print_errors($errors); ?>
<form method="post">
    <input type="hidden" name="csrf_token" value="<?php print h(csrf_token()); ?>">
    <p><label>First name: <input type="text" name="first_name" maxlength="80" required value="<?php print h($member->first_name); ?>"></label></p>
    <p><label>Last name: <input type="text" name="last_name" maxlength="80" required value="<?php print h($member->last_name); ?>"></label></p>
    <p><label>Email: <input type="email" name="email" maxlength="190" required value="<?php print h($member->email); ?>"></label></p>
    <p><label>Username: <input type="text" name="username" maxlength="50" required value="<?php print h($member->username); ?>"></label></p>
    <p><label>Password (8+ characters): <input type="password" name="password" minlength="8" required></label></p>
    <button type="submit">Create Member Account</button>
</form>
</body></html>
