# WEB-250 Assignment 10: Update and Delete a Bird

For this assignment, I built on asgn09 by adding the ability to update and delete bird records. This completes the four CRUD operations: Create, Read, Update, and Delete.

I added an `update()` method to the Bird class to save changes to existing records and a `delete()` method to remove records from the database. Both methods use prepared statements and the bird's ID to make sure the correct record is changed.

The edit page uses GET to load a bird's current information and POST to save changes. The delete page displays a confirmation before using POST to delete the selected bird.

## Running Locally

1. Place the project in MAMP's `htdocs` folder.
2. Set up `private/db_credentials.php` using the example file.
3. Start MAMP and visit:

   `http://localhost:8888/web-250/asgn10-birds/public/birds.php`

## Links

- **GitHub:** https://github.com/Parzival1701/web-250
- **Live Site:** https://andrewjonesdev.com/web250/asgn10-birds/public/birds.php
