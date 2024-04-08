## api-coding-test
A test based API public repo
# Human Resource Management System

This is an web application for managing Comany resources and it's Employees. It was built using Laravel 10.
<br>
<br>
The application was a requirement for my test "On the Job Application process" in a company that I've applied for.

## Server Requirements:

1.PHP 8.0
2. Composer
3. XAMPP or WAMP server 

## Steps to run this application locally:

1. Click on `<> Code` button
2. Copy the HTTPS/SSH repository link
3. Run `git clone` command on your terminal.
4. Install the necessary dependencies by running `composer install`
5. Creating .env file by `cp .env.example .env` and fill in the necessary fields, e.g.: database connection, etc.
6. Generate the application key by running `php artisan key:generate`
7. Next, run the database migration with this `php artisan migrate` command.
8. You can seed the database with `php artisan db:seed` command.
9. Lastly, serve the application with this `php artisan serve` command.
10. The HRMS application should accessible on your API client eg POSTMAN on "http://localhost:8000"
10. Register a new user via "http://localhost:8000/api/auth/register"

### Login Credentials

You can log into the application with this credentials (if you did the database seeding).

-   Username: `user@gmail.com`
-   Password: `1234567890`

## API Documentation on how to use the endpoints
You can use this link to test all the endpoints after the setup via "https://documenter.getpostman.com/view/22559003/2sA35MxycH"
  