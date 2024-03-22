# Cerfvolant.org

## About
cerfvolant.org is a mini project for an instant messaging system that is continuously being improved. It provides a platform for real-time communication between users.

## Features
- User registration and authentication system
- Sending and receiving instant messages
- Real-time updates for new messages
- Basic user profile management

## Setup
To use cerfvolant.org, follow these steps:

1. Clone the repository to your local machine.
2. Set up your database by filling in the necessary details in `basededonnées.php` and creating the required tables.
3. Create a table named `User` with 6 columns :
   - id (int autoincrement)
   - email (string)
   - userName (string)
   - passWord (string)
   - Image (file path)
   - Date (time stamp at the creation of the line)
4. Create a table named `messages` with 5 columns :
   - idAuthor (int)
   - idDest (int)
   - idMSG (int autoincrement)
   - MSG (string)
   - temps_ajout (time stamp at the creation of the line)
5. Configure your web server to serve the application.
6. Access the application through your web browser.
7. Register a new account or log in with existing credentials.
8. Start sending and receiving messages with other users.



To use 


2. Set up your database by filling in the necessary details in `basededonnées.php` and creatin
3. Configure your web server to serve the application.
4. Access the application through your web browser.
5. Register a new account or log in with existing credentials.
6. Start sending and receiving messages with other users.

## Requirements
- PHP
- MySQL or MariaDB
