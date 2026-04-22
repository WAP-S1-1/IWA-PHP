# IWA-PHP

## Requirements

- PHP IDE (IDE support for PHP 8.5 is recommended)
- Laravel 12
- MySQL
- Composer
- IWAGenerator (for loading monitoring data)
## Installation

1. Navigate to the Webapp directory:
   ```bash
   cd Webapp
2. run the following command to install the dependencies or use your IDE's built-in composer support:
   ```bash
   composer install 
3. Create a copy of the .env file:
   ```bash
   cp .env.example .env
4. Update the .env file with your database credentials and other necessary configurations.
5. Run the following command to generate an application key:
   ```bash
   php artisan key:generate
6. Run the following command to generate an application key:
   ```bash
   php artisan jwt:secret
7. Run the following command to run the database migrations:
   ```bash
   php artisan db:seed
8. Finally, start the development server:
   ```bash
   php artisan serve

9. You can access the application at http://localhost:8000.
10. Run the IWAGenerator in the background to load the monitoring data


## User account
- Admin account:
    - Employee ID: A0011
    - Password: password
- Others : Pre-existing accounts are available in the database, you can use them to log in and test the application.
## Error handling
- When receiving an error at step 2, ensure that you have the extensions enabled in your PHP configuration (php.ini):
    - pdo_mysql
    - mbstring
    - openssl
    - fileinfo
- If you encounter issues when running the migrations, ensure that your database credentials in the .env file are correct and that the MySQL server is running.
  You can also try running the following command to refresh the migrations and seed the database:
  ```bash
  php artisan migrate:refresh--seed
  ```
- If step 5 fails ensure that composer was installed inside the webapp directory 