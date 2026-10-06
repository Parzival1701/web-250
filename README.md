# Bike and Bird Challenge
## Student
Andrew Jones
## Course
WEB 250
## Project Overview
This project demonstrates the use of a csv file containing data to be parsed and turned into objects then displayed in a table. 
## Bike Challenge
This part of the assignment is directly from the lecture videos from LinkedIn Learning. It uses a parseCSV class to display weight in kg and pounds. 
## Bird Challenge
Birds uses a pipe delimiter to parse and display bird objects in a html table. 
## Concept Check
### 1. Static Property vs Constant
A static property belongs to the class and not individual object instances and a constant is fixed value. 
### 2. Constructor `$args` Array
The args array holds all of the key value pairs on each line that is turned into an object instance of the bird class. It is used to populate the new instance with data. 
### 3. Public vs Protected
public properties can be called and referenced anywhere in code and protected ones are only for class and subclasses. 
### 4. Private `reset()`
This resets the data on the page. 
### 5. `self::CONSERVATION_OPTIONS`
This is a protected constant array of conservation levels for each class instance. Then are inherited but not changeable. 
### 6. `money_format()` vs `number_format()`
Money format is an antiquated way to format money in php and numberformat is a modern solution. 
## Git History
Paste the output of:
asgn05_bike_bird_challenge.md 2026-09-23
6 / 38
```text
git log --oneline --graph --all --decorate
* 8840f83 (HEAD -> main, origin/main) adding missed comments
* 5ff5316 (asgn05-bird) worked up to the end, just need to answer questions and make a read me
* 5d24b2b (origin/asgn05-bird)  saving buggy table that is not displaying correctly
* 0917a47 Constructed the loop logic for the constructor to pass the csv arrays to each class variables
* 6be178a editing the way that the display function looks
* fc68655 finished the birds class with all variables, methods and constants
* 77b9330 file setup for birds
* c8a82ad finishing minor editing of bikes
* 140bea2 (asgn05-bike) idk what commit this is
* 6205c33 adding asgn05-bike and fixing the money format
* 1f2197a more commits
```
## AI Log
- Question asked:
- How the answer was used:
 how to write a readme. The answer was used to make sure I used the correct format and answered the correct questions. 

I sent claude three of my files and the rubric and asked it what I forgot to answer. The answer was several comments and changes to a the if else structure of displaying my table that I did not understand, so I left it with my original idea that is not working. 
