![GitHub last Commit](https://img.shields.io/github/last-commit/krofunk/candystats.svg)
![GitHub repo size](https://img.shields.io/github/repo-size/krofunk/candystats.svg)
![GitHub issues](https://img.shields.io/github/issues/krofunk/candystats.svg)
# About
> PHP Script for storing and reporting on CSGO server logs in an awesome way.
> -Naiboss.

Logs are parsed by the script and then stored in a database; it is then easy to write queries to get the data out. 
The user facing website should give good insights but the plan is to also provide an API. 

# Finished features
1. Drag and Drop log upload (multiple files at once!)
2. Basic global stat extraction
3. Basic player stats and graphs
4. Basic Scoring System
5. Global leader board

# Currently working on
1. Processing logs
2. CandyStat configuration (for end user admins)
3. Game session (log file) management/filtering

# Not currently working on
1. Logins. (Probably one of the last things I will look at)
2. Dangerzone logs - This newly added game mode uses a very different log format...

---
# Requirements
**_As CandyStats is under active development (and isn't close to finished/working) there is a good chance these requirements will change!_**
1. Web server (Apahce and IIS tested)
2. PHP 5.6 and up (tested with 5.6.38 and 7.2.10)
3. PHP_GMP **_MUST-** be installed/enabled. (uncomment extension=php_gmp.dll (PHP 5) or extension=gmp (PHP 7) in your PHP.ini on Windows.) 
4. Steam API key (https://steamcommunity.com/dev/apikey)
3. MySQL 5.7

# Installation
1. Place directory on your web server. 
2. Create a "candystats" database on your MySQL server.
3. Import the _candystats.sql_ table into the database.
4. Rename resources/config-template.php to config.php
5. Edit config.php, fill in your MySQL credentials and Steam API key.

You should now be able to navigate to the directory on your web server via your web browser and begin uploading logs.