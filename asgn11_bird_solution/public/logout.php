<?php
// Resume the existing session before trying to clear it; send no HTML first.
require_once dirname(__DIR__) . '/private/initialize.php';

// The helper empties session data, expires its cookie when used, and destroys
// the server-side session. Clearing only the member ID would leave other data.
log_out();

// Return to the public home page. The helper sends Location and exits,
// so this request finishes without rendering a separate logout page.
redirect_to('index.php');
