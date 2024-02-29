# A2Movies

![How it looks](screenshot.png)

**A2Movies** is a locally-hosted website built using HTML, CSS, Javascript, and PHP.

## Features

- The website allows users to browse an e-booking website.
- Users can search by movie title.
- Users are able to register for an account if they do not have one already (Not implemented as of Deliverable 3). 
- Administrators are able to login in through the Administrator Login Portal (Not implemented as of Deliverable 3).
- From the Admin portal, administrators are able to add new movies, remove movies, and edit all aspects of the movie entry in the database.
- As of Deliverable 3 administrators are only able to add new movies into the database from the webiste.

## Running
Before running the website, you need to install Xampp which can be downloaded [here](https://www.apachefriends.org/download.html).<br>
Clone the repository into the 'htdocs' folder inside of your Xampp directory.
You should then be able to run the website from localhost.
You should use phpmyadmin 'localhost/phpmyadmin' to initialize the movie database using the 'initialize_db.sql' file found inside of the DB folder. 
You should adjust the 'includes/databaseConnection.inc.php' file according to your local database login info.

## Project Architecture

The website uses PHP, HTML, CSS, and Javascrip to display the pages and interactable features.<br>
It reads and writes from the database using PHP to generate SQL scripts.<br>


