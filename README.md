# About
> PHP Script for storing and reporting on CSGO server logs in an awesome way.
> -Naiboss.

Logs are parsed by the script and then stored in a database; it is then easy to write queries to get the data out. 
The user facing website should give good insights but the plan is to also provide an API. 

---
# Requirements
**_As CandyStats is under active development (and isn't close to finished/working) there is a good chance these requirements will change!_**
1. Web server (Apahce and IIS tested)
2. PHP 5.6(ish)
3. MySQL 5.7

# Installation
1. Place directory on your web server. 
2. Create a "candystats" database on your MySQL server.
3. Import the _logdata.sql_ table into the database.
4. Update resources/config.php with your MySQL credentials

You should now be able to navigate to the directory on your web server via your web browser and begin uploading logs.