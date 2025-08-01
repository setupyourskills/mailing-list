# Mailing List Registration

This project is a simple, secure, and modern web application for collecting user registrations to a mailing list.  

It is built with **HTML**, **CSS** (dark theme), **JavaScript** (form validation and AJAX), and **PHP** (backend, PDO, and MySQL/MariaDB).

## Features

- Simple yet handy registration form
- Client-side and server-side validation
- Secure database storage (PDO, prepared statements)
- Error and success messages with clear feedback
- Clean code structure (separation of concerns, reusable classes)
- Environment-based configuration (no credentials in code)

## How to Use

1. **Configure your database:**
   - Create a MySQL/MariaDB database and a `users` table with the following structure:
     ```sql
     CREATE TABLE users (
       id INT AUTO_INCREMENT PRIMARY KEY,
       name VARCHAR(100) NOT NULL,
       email VARCHAR(255) NOT NULL UNIQUE,
       time TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
     );
     ```

   - Set your database credentials in `db_config.php` (replace with your own values):
     ```php
     <?php

     define("DB_HOST", "localhost");
     define("DB_USER", "username");
     define("DB_PASS", "password");
     define("DB_NAME", "database_name");
     ```

   - Then, move this file outside of the web root directory.

2. **Deploy the project on your PHP server (Apache, Nginx, etc.).**

3. **Open the application in your browser and test the registration form.**

## Project Structure

- `index.html` – Main registration page
- `style.css` – Dark theme style
- `script.js` – Client-side validation and AJAX
- `add_user.php` – Backend handler for registration
- `classes/` – PHP classes (Messages, Validator, Database and ResponseHandler)
- `../secret/db_config.php` – Configuration file for database credentials

Feel free to adapt the project to your needs!
