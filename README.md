# PHP-Login-Registration-System
A secure login and registration system built with PHP, MySQL, HTML, and CSS. This project includes user authentication, password hashing, session management, and a "Forgot Password" feature using PHPMailer to send reset links via Gmail.

## Features
- User Registration with secure password hashing
- Login authentication with session management
- Forgot Password functionality using PHPMailer
- Email verification for password reset
- Mobile-friendly responsive design
- Secure input validation and error handling

## Technologies Used
- **Backend:** PHP (Procedural or OOP)
- **Database:** MySQL
- **Frontend:** HTML, CSS
- **Email Handling:** PHPMailer (SMTP with Gmail)

## Installation
1. Clone this repository:
   ```sh
   git clone https://github.com/nathaniel1024/PHP-Login-Registration-System.git

- Use the following SQL script to create the `users` and 'password_resets' table:

     ```sql
     CREATE TABLE `feifei`.`users` (
	      `id` INT NOT NULL AUTO_INCREMENT , 
	      `name` VARCHAR(255) NOT NULL , 
	      `email` VARCHAR(255) NOT NULL , 
	      `password` VARCHAR(255) NOT NULL , 
	      PRIMARY KEY (`id`), 
	      UNIQUE (`email`)
      ) ENGINE = InnoDB;

     CREATE TABLE `feifei`.`password_resets` (
	     `id` int(11) NOT NULL,
        `email` varchar(255) NOT NULL,
        `token` varchar(100) NOT NULL,
        `expires` datetime(6) NOT NULL
      ) ENGINE = InnoDB;

### Desktop View
<p align="center">
  <img src="https://github.com/user-attachments/assets/b6b56934-a2e5-499a-85a7-d45f788e2550" alt="Desktop 1" />
  <img src="https://github.com/user-attachments/assets/9256edfb-81f5-4ca4-ba07-459bc4e7386d" alt="Desktop 2" />
  <img src="https://github.com/user-attachments/assets/f1976a88-3431-4715-9997-c7f70c6e6edf" alt="Desktop 3" />
</p>

### Mobile View
<p align="center">
  <img src="https://github.com/user-attachments/assets/02e340de-aad9-4fdf-89cf-340a8a9b4b68" alt="Mobile 1" />
  <img src="https://github.com/user-attachments/assets/d6bcca50-5ab9-4954-8732-d61beef7acf1" alt="Mobile 2" />
  <img src="https://github.com/user-attachments/assets/0e110cc4-9805-45fe-9100-d4a1e40c333f" alt="Mobile 3" />
</p>
