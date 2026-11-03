# WEB 250 - asgn09: Create a Record

I created a Bird class method that would take an user populated object created from bird_new.php's form and insert the values into the sql database using prepared statements and bound values. This create() method fulfills the create portion of CRUD.Bird.php, which holds the Bird class acts as the model. The birds.php acts as the view displaying the use input being added to the database. The application is one step close to toward a full MVC layout, but not quite there yet. 

# How prepared statements work
The pdo prepared statement provides security by first sending the layout of the sql statement to the database and then adding the user input as variables afterword. The user input is then just treated as input and sql knows not to read it as more than that. 

## Assignment goal

Add the **Create** portion of CRUD using:

- `public/bird_new.php`
- a `Bird::create()` instance method
- a PDO prepared `INSERT`
- named placeholders and `bindValue()`

## Database

Use the existing `wnc_birds` database and `birds` table from the previous assignments.


