# WNC bird Directory 
This exercise was to demonstrate a centralized PDO class database connection as well as added security of prepared statements, try catch blocks and h() to protect against cross site scripting. keeping one central database connection keeps the overhead low and queries static to each object class. 

# Features 
- index page showing connection
- birds.php showing looped rows in a table representing each bird object. 
- bird.php showing individual bird objects found by id 
- 400 and 404 errors
- prepared statements and escaping 

# structure 
public/
index.php Home page
birds.php Bird directory
bird.php Single bird details
private/
initialize.php Loads classes and sets up the database
Bird.php Active Record model
Database.php Connection class
