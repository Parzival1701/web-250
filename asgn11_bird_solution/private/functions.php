<?php
// Shared helpers keep pages focused on their own forms and records. These
// functions handle repeated tasks such as output, identity, and permission checks.

// Escape text when displaying it in HTML, including quoted input attributes.
function h(mixed $value): string
{
    // Convert null to an empty string to avoid a PHP deprecation warning.
    // ENT_QUOTES escapes both quote types; the stored database value is unchanged.
    return htmlspecialchars((string) ($value ?? ''), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

// A GET normally displays the page; POST tells our form pages to process a submission.
function is_post_request(): bool
{
    return ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST';
}

// Redirect after a successful action so refreshing the destination does not
// repeat that POST. The never return type fits a helper that always exits.
function redirect_to(string $relative_path): never
{
    header('Location: ' . $relative_path);
    // Sending a header does not stop PHP; exit prevents the remaining page from running.
    exit;
}

// Call only after the login page has verified the submitted password.
function log_in(Member $member): void
{
    // Replace the pre-login session ID, reducing the risk of session fixation.
    session_regenerate_id(true);
    // Keep only the account ID; later requests can load current account details.
    $_SESSION['member_id'] = (int) $member->id;
}

function current_member(): ?Member
{
    // The session stores only the member ID, NOT their first name or role.
    // Each request reads the current member data from MySQL.
    $id = filter_var($_SESSION['member_id'] ?? null, FILTER_VALIDATE_INT,
        ['options' => ['min_range' => 1]]);
    // A missing or invalid ID means there is no usable signed-in account.
    if ($id === false || $id === null) {
        return null;
    }
    // The lookup returns an object or null. Reading fresh data means name/role
    // changes are reflected without relying on old values copied into the session.
    return Member::find_by_id((int) $id);
}

// A session ID alone is not enough: the account must still exist in the database.
function is_logged_in(): bool
{
    return current_member() !== null;
}

function is_member(): bool
{
    $member = current_member();
    // Admins may also do everything that ordinary members do with birds.
    return $member !== null && in_array($member->role, ['member', 'admin'], true);
}

// This narrower role check distinguishes an admin from an ordinary member.
function is_admin(): bool
{
    $member = current_member();
    return $member !== null && $member->role === 'admin';
}

function require_member(): void
{
    // Protect the request itself, including a typed URL or directly submitted form.
    // Hiding Create/Update/Delete links only controls the menu, not access to PHP.
    if (!is_member()) {
        http_response_code(403);
        exit('<h1>403 - Member access required</h1><p><a href="login.php">Login</a></p>');
    }
}

// Clear both the server-side login data and the browser's session cookie.
function log_out(): void
{
    // Empty the current request's copy of the session, including the member ID.
    $_SESSION = [];
    if (ini_get('session.use_cookies')) {
        // Expire the cookie using its existing path/domain/settings so the browser
        // removes the matching cookie. A time in the past marks it as expired.
        $settings = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, $settings['path'], $settings['domain'],
            $settings['secure'], $settings['httponly']);
    }
    // Remove the stored server-side session data; this does not clear $_SESSION
    // or the cookie by itself, which is why those steps happen above.
    session_destroy();
}

// Reuse one unpredictable form token for this session. Forms include it in a
// hidden input so the POST handler can check it against the server's copy.
function csrf_token(): string
{
    if (empty($_SESSION['csrf_token'])) {
        // Hex turns random bytes into printable text suitable for an HTML value.
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return (string) $_SESSION['csrf_token'];
}

// Check the token before an INSERT, UPDATE, or DELETE. Knowing a form's URL
// alone should not be enough for another site to submit a valid change request.
function require_valid_csrf(): void
{
    $expected = (string) ($_SESSION['csrf_token'] ?? '');
    $received = (string) ($_POST['csrf_token'] ?? '');
    // Reject missing tokens; hash_equals provides a timing-safe string comparison.
    if ($expected === '' || !hash_equals($expected, $received)) {
        http_response_code(403);
        exit('<h1>403 - Invalid form token</h1>');
    }
}

// One shared renderer gives forms consistent feedback without duplicating markup.
function print_errors(array $errors): void
{
    if (!$errors) {
        return;
    }
    print '<h2>Please correct the following:</h2><ul>';
    foreach ($errors as $error) {
        // Escape messages too, since future validation text might include user input.
        print '<li>' . h($error) . '</li>';
    }
    print '</ul>';
}

// Validate on the server even though the HTML form also uses required/maxlength.
// Returning all errors lets the page redisplay the form and explain what to fix.
function bird_form_errors(Bird $bird): array
{
    $errors = [];
    // Required names and length limits match the reference birds table's columns.
    if ($bird->common_name === '' || strlen($bird->common_name) > 150) {
        $errors[] = 'Common name is required (maximum 150 characters).';
    }
    if ($bird->scientific_name === '' || strlen($bird->scientific_name) > 150) {
        $errors[] = 'Scientific name is required (maximum 150 characters).';
    }
    if (strlen($bird->family_name) > 150 || strlen($bird->primary_habitat) > 255 ||
        strlen($bird->seasonal_status) > 100) {
        $errors[] = 'One of the bird fields is too long.';
    }
    return $errors;
}
