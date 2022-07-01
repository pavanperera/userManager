
## Setting Up User Manager

[Click here for the Api documentation](https://documenter.getpostman.com/view/9089288/UzJESK83)

Techonology stack used.

- PHP 7.4
- Laravel 9
- MariaDB

Step by step installation

1. Clone the project into the development/deployment environment with PHP 7.4.
2. Create a MariaDB database.
3. Using the .env.example create the .env file and give the needed base url and database configurations.
4. Navigate to the project directory through terminal and run the following commands.
    - composer update
    - php artisan migrate
    - php artisan passport:install
    - php artisan vendor:publish --provider="Proengsoft\JsValidation\JsValidationServiceProvider" 
    - php artisan serve
 5. Now, head to the configured domain or http://127.0.0.1:8000/ to access the application
 6. First register a user and login to start using the application.
