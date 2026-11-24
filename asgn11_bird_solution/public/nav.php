<?php
// Shared navigation. Include after private/initialize.php on EVERY public page.
// One shared file keeps the menu consistent when we change its links or labels.

// Look up the session's member ID in MySQL to get the current name and role.
// A visitor has no Member object, so current_member() returns null.
$nav_member = current_member();

// Both members and admins may maintain birds. The null check prevents reading
// a role from a nonexistent object; true makes the role comparison strict.
$nav_can_edit_birds = $nav_member !== null &&
    in_array($nav_member->role, ['member', 'admin'], true);

// The conditions below select useful links; protected pages still check access.
// Signed-in people see an escaped first_name beside Logout, not Login/Register.
// Using the database name means a later name change appears on the next request.
?>
<nav>
    <a href="index.php">Home</a> |
    <a href="birds.php">Birds</a>
    <?php if ($nav_can_edit_birds) { ?>
        | <a href="bird_new.php">Create Bird</a>
    <?php } ?>
    <?php if ($nav_member !== null) { ?>
        | <a href="logout.php">Logout</a>, <?php print h($nav_member->first_name); ?>
    <?php } else { ?>
        | <a href="login.php">Login</a>
        | <a href="signup.php">Register</a>
    <?php } ?>
</nav>
<hr>
