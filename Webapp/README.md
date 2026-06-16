Project Naam: Webapp met REST API

Dit project bestaat uit een frontend webapplicatie (gebouwd met Vite/Node.js) 
en een backend REST API (gebouwd met Laravel/PHP). 
Om de applicatie lokaal te draaien, moeten zowel de frontend als de twee backend componenten tegelijkertijd actief zijn.



## Vereisten (Prerequisites)
Zorg ervoor dat de volgende software op je computer is geïnstalleerd:
* [Node.js](https://nodejs.org/) (voor de frontend)
* [PHP](https://www.php.net/) & [Composer](https://getcomposer.org/) (voor de Laravel backends)
* Een lokale database server (bijv. XAMPP / MySQL)


Open de terminal of run de volgende
command: git clone -b development https://github.com/WAP-S1-1/IWA-PHP.git


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

DB_DATABASE = laravel

5. Run the following command to generate an application key:
   ```bash
   php artisan key:generate
6. Run the following command to generate an application key:
   ```bash
   php artisan jwt:secret
7. Run the following command to run the database migrations:
   ```bash
    php artisan migrate:fresh --seed
8. Finally, start the development server:
   ```bash
   php artisan serve
   
And now we need to do the same for the Zalora directory.

1. Navigate to the Zalora directory:
   ```bash
   cd Zalora
2. run the following command to install the dependencies or use your IDE's built-in composer support:
   ```bash
   composer install 
   
4. Run npm install
    ```bash 
   npm install
``
3. Create a copy of the .env file:
   ```bash
   cp .env.example .env

5. Run the following command to generate an application key:
   ```bash
   php artisan key:generate
6. Run the following command to generate an application key:
   ```bash
   php artisan jwt:secret
7. Run the following command to run the database migrations:
   ```bash
    php artisan migrate:fresh --seed
8. Finally, start the development server:
   ```bash
   php artisan serve --port=8080




