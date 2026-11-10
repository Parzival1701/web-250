# WEB 250 - Salamander CRUD Sandbox Solution

This project is the ungraded practice application for asgn10.

It uses the existing `wnc_salamanders` database but creates a separate `crud_salamanders` table so the older three-table PDO exercises remain untouched.

## Setup

1. Import `sql/crud_salamanders.sql`.
2. Copy `private/db_credentials.example.php` to `private/db_credentials.php`.
3. Enter the local database settings.
4. Open `public/salamanders.php`.

## CRUD pages

- Create: `public/salamander_new.php`
- Read/list: `public/salamanders.php`
- Update: `public/salamander_edit.php`
- Delete confirmation: `public/salamander_delete.php`

The Update page intentionally resembles the Create page. The goal is to make the changed responsibilities easy to see rather than introduce a larger form abstraction.

The actual Delete is performed only on POST. GET displays the confirmation page.
