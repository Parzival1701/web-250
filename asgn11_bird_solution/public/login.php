<?php
// Initialize before output so session cookies and redirects can send headers.
require_once dirname(__DIR__) . '/private/initialize.php';

// A signed-in account goes straight to the bird directory instead of logging in again.
if (is_logged_in()) {
    redirect_to('birds.php');
}

$errors = [];
$username = '';

// GET shows the blank form. POST checks the credentials the user submitted.
if (is_post_request()) {
    // Reject a missing or incorrect session form token before checking credentials.
    require_valid_csrf();

    // Keep the username available for redisplay after a failed attempt.
    // Do not trim the password: leading or trailing spaces may be intentional.
    $username = trim((string) ($_POST['username'] ?? ''));
    $password = (string) ($_POST['password'] ?? '');

    // The class handles the prepared SELECT; no match produces null.
    $member = Member::find_by_username($username);

    // The null check must succeed before we read the object's password_hash.
    // Verify the submitted password against its stored hash; do not hash it again.
    if ($member !== null && password_verify($password, $member->password_hash)) {
        // log_in() renews the session ID and stores this member's numeric ID.
        // redirect_to() then ends this request, so the error below is skipped.
        log_in($member);
        redirect_to('birds.php');
    }

    // Use one message for either failure so we do not reveal which usernames exist.
    $errors[] = 'Invalid username or password.';
}

// The form escapes the retained username with h() and includes the session token.
// Its password field stays empty after a failure; the password is never printed.
?>
<!doctype html>
<html lang="en"><head><meta charset="utf-8"><title>Member Login</title></head><body>
<?php require __DIR__ . '/nav.php'; ?>
<h1>Login</h1>
<?php if (isset($_GET['registered'])) { ?><p>Registration succeeded. Please log in.</p><?php } ?>
<?php print_errors($errors); ?>
<form method="post">
    <input type="hidden" name="csrf_token" value="<?php print h(csrf_token()); ?>">
    <p><label>Username: <input type="text" name="username" required value="<?php print h($username); ?>"></label></p>
    <p><label>Password: <input type="password" name="password" required></label></p>
    <button type="submit">Login</button>
</form>
</body></html>
