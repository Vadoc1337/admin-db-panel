# Web-interface of the database of registered site users for the administrator

## Access to admin panel:

**Login**:admin
<br/>
**Password**:admin1337

## Functionality and features of the project

* Ability to view, sort users, make changes to the user record, add new users, delete users from the database. These privileges have only the administrator after entering the appropriate login and password to access the admin panel
  Passwords of users and the admins are stored in encrypted form
* Adaptive layout
* The database is stored on hosting hoster.ru
* There is a page of error 404 processing
* There is pagination and the ability to search for a particular user in the database
* This project has also been uploaded to free hosting 000webhost.com for a more visual demonstration
* Technology stack: ```PHP 8.3, MySQL 5.6.40, HTML,Js,Css(Bootstrap library) (latest versions)```

## Start the project

1. Open the file [login.php](public/login.php) or [index.php](public/index.php) which are located in the folder ```public``` (there is no difference, because if the admin is not logged in, by default there is a redirect to the page
   login.php for unregistered users) on the php server or at the link on the site 000webhost.com.
2. Everything works, you are great.

## Project Structure

### 1. SQL Database

* [Connection config](config/database.php)  to the database is in the  ```config``` folder. The default site is hoster.ru (you can change it to a local server if you need to).

* [Dump-SQL file](DATABASE/Database_dump.sql) is located in the ```DATABASE``` folder. There are two tables, the first - **users**, directly with user data, and the second **admins**, which contains the administrators login and password
  field.

* There is also a [password generator](utils/generate_password.php) in encrypted form in the ```utils``` folder, which can be used to add new administrators.

### 2. The rest of the project files

* The [classes](classes) folder contains PHP classes used for authentication, database operations, and user management.
* The [public](public) folder contains publicly accessible files such as CSS, JavaScript, and images. And it also includes the main entry point files like index.php, login.php, and user_form.php.
* The [views](views) folder contains PHP files responsible for rendering HTML views like
    + user_form.php (functionality for editing user information and adding a new user),
    + user_delete.php (functionality of deleting users),
    + user_details.php (card-information about the user).