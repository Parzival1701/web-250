1. Why does this many-to-many design use three tables instead of putting one bird_id in bird_images?
-One bird ID can be related to many bird images, and one bird image could be related to many bird ids. In this table it is used to show that there are male and female birds. Both male and female birds are still the same species. 
2. What happens to the links, image records, and physical JPEG files when a species record is deleted?
-All of this information remains in the file structure. 
3. What does the PDO DSN contain, and why is Database::$connection static?
PDO dsn contains the connection information to the database. The connection is static because you do not need a new instance to connect to the same database. You call the connection that happens in the class, that way it is centrally located and cant be changed. 
4. What is the difference between query() and fetchColumn() in the count example?
query is runs the sql statement and fetch displays the results. Both are methods of the PDO object. 
