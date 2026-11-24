# WEB-250 Assignment 11 — WNC Birds

This is the instructor reference for **Composer + `.env` + Member authentication + personalized navigation**. Continue from your working Assignment 10 birds project, using PDO and Active Record. No CSS or MVC restructuring is required.

## Moderately commented edition

This edition adds teaching comments to all 16 application PHP files and the reference SQL. Comments explain **how the main blocks work and why they belong in this application**, with extra attention to initialization, Active Record, prepared statements, session identity, password handling, validation, and shared forms/navigation. Ordinary assignments and HTML fields are grouped rather than explained line by line.

The application is the most recent Assignment 11 instructor solution. Executable PHP, SQL statements, HTML, function names, and file organization are preserved. Administrator member-management functionality remains in Assignment 12.

### Suggested reading order

1. `private/initialize.php` — how each request receives Composer, configuration, sessions, classes, and one shared PDO connection.
2. `private/classes/Database.php` — how the `.env` values become that connection.
3. `private/classes/Member.php` — how rows become account objects, validation collects errors, and registration saves a password hash.
4. `public/signup.php` and `public/login.php` — how a form request reaches the Member methods.
5. `private/functions.php`, `public/nav.php`, and `public/logout.php` — why the session stores an ID, how the greeting stays current, and how logout removes the login state.
6. `private/classes/Bird.php` and the Bird pages — how the same object/database pattern supports reading and changing birds.

`composer.json` remains valid JSON, which does not allow ordinary code comments. Its role is explained in `initialize.php` and the setup steps below: Composer reads the dependency declaration and generates `vendor/autoload.php` so the Dotenv package can be loaded.

## Quick setup (MAMP / XAMPP / VS Code)

1. Put `asgn11_bird_solution/` in your local WEB-250 work folder.
2. Open the VS Code terminal in **the folder that contains `composer.json`**.
3. Run `composer install`. This installs `vlucas/phpdotenv` and creates `vendor/` and `composer.lock` if missing. Commit `composer.lock`, not `vendor/`.
4. Copy `.env.example` to `.env` **in this same folder**. Edit the database host, port, database, username, and password. Common MySQL ports are 3306 (XAMPP) or 8889 (some MAMP configurations); use your actual port.
5. Select your existing `wnc_birds` database in phpMyAdmin. Make sure `members` exists; reference SQL is at `sql/reference_schema.sql`. It is safe to read, but **compare schemas before running any SQL**. Do not overwrite the birds table or discard earlier work.
6. With the terminal still at this project root, start the development server with `php -S localhost:55000 -t public`. In your browser open `http://localhost:55000/index.php`. Stop another server using that port before starting this one.
7. Or configure MAMP/XAMPP to serve **only `public/`** as its document root. A local URL served from a higher `htdocs` directory may instead contain `/web250/asgn11_bird_solution/public/index.php`.

## Personalized menu

- Signed out: `Home | Birds | Login | Register`
- Signed in as a regular member: `Home | Birds | Create Bird | Logout, Charlie`
- Signed in as an administrator: `Home | Birds | Create Bird | Logout, Charlie`

`public/nav.php` uses `current_member()` to load a `Member` object. The greeting uses `first_name`, not `username`. Both roles can maintain birds. **Administrator member-management pages are part of Assignment 12, not this solution.**

`public/login.php` and `public/signup.php` redirect signed-in users to the bird directory. `public/bird_new.php`, `bird_edit.php`, and `bird_delete.php` independently call `require_member()` so manually typing the URL does not bypass authorization.

## Important files

| File | Purpose |
|---|---|
| `private/initialize.php` | Loads Composer, `.env`, sessions, classes and PDO |
| `private/classes/Database.php` | PDO connection using `.env` values |
| `private/classes/Member.php` | Registration, `find_by_username()`, `find_by_id()` and password hashing |
| `private/functions.php` | Session, `current_member()`, authorization, CSRF and `h()` |
| `public/signup.php` | Registers a regular member only |
| `public/login.php` | Uses `password_verify()`, then `log_in()` |
| `public/nav.php` | Personalized navigation, includes first name |
| `public/logout.php` | Destroys the session and returns to Home |
| `public/bird_*.php` | Existing Bird CRUD with server-side access checks |

## Database compatibility

The instructor package uses a **reference** Bird schema (`id`, `common_name`, `scientific_name`, `family_name`, `primary_habitat`, `seasonal_status`, `description`). If your own Assignment 10 birds table differs, **keep the already-working `Bird.php` and Bird pages**. Add the Member / session / navigation changes to your working application rather than forcing your database to match this sample.

## Security and source control

- `.env` is a private credentials file and must never be committed. `.env.example` is safe to commit; it contains placeholders.
- `vendor/` is generated locally by Composer and ignored by Git. On the webhost, run `composer install` there or upload the `vendor/` directory securely if the host has no Composer command.
- `.gitignore` does not protect private files from web requests. In production, configure the **web document root to `public/`**. Do not expose `.env`, `private/`, `vendor/`, or `sql/` through the web server.
- Public registration always uses `role='member'`; never trust a role sent by the visitor.
- Stored passwords are hashes (`password_hash()`), verified with `password_verify()`. Do not print hashes on web pages.
- Forms that change information use a CSRF token. Permission checks run on the server before restricted Bird CRUD pages.
- No real secrets or credentials are included in this ZIP.

## Instructor checklist

1. Register a member with first name `Charlie` and a username **different** from Charlie. Confirm the public row has role `member` and the password is hashed.
2. While signed out, see `Login | Register`; browsing birds succeeds, but direct `bird_new.php` returns HTTP 403.
3. Log in with the member's username/password. Confirm the menu displays **`Logout, Charlie`** and does **not** show `Login` or `Register`.
4. Refresh on `index.php`, `birds.php`, and `bird.php`. Confirm the same greeting.
5. Create, update, and delete a bird using a test record. Verify the MySQL rows change.
6. Log out. `Login` and `Register` return, `Create Bird` disappears, and a direct edit URL fails.
7. To test administrator personalization without adding Assignment 12 features, register a separate test user such as `admin_demo` and, in phpMyAdmin, manually change **that account only** to `role='admin'`; log in and confirm the same greeting. Do not provide a public admin-promoting script.
8. Test locally **and** on the webhost, then check GitHub for accidentally tracked `.env` or `vendor/`.

All 16 application PHP files passed syntax checks. A PHP-token comparison confirmed that, after removing comments and PHP whitespace, every application file matches the original—including its SQL strings and inline HTML. This was a commenting pass; the database/browser checklist above remains the guide for running the application in your own teaching setup.

## Reference documentation

These links support the PHP and dependency behavior explained in the comments:

- [PHP PDO prepared statements](https://www.php.net/manual/en/pdo.prepare.php)
- [PHP password hashing](https://www.php.net/manual/en/function.password-hash.php) and [verification](https://www.php.net/manual/en/function.password-verify.php)
- [PHP sessions](https://www.php.net/manual/en/function.session-start.php) and [session destruction](https://www.php.net/manual/en/function.session-destroy.php)
- [PHP HTML escaping](https://www.php.net/manual/en/function.htmlspecialchars.php)
- [Composer basic usage](https://getcomposer.org/doc/01-basic-usage.md)
- [phpdotenv documentation](https://github.com/phpdotenv/phpdotenv)
