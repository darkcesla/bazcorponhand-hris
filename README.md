# PHP 8 Project with Laravel

This is a PHP project developed using Laravel and PHP 8 or higher, with MySQL 5.6 as the database server. Below are the instructions to set up and run the project on your local Windows machine.

## Prerequisites

Before you begin, ensure you have the following installed on your local machine:

-   PHP (>= 8.0) - Make sure to add PHP to your PATH environment variable during installation.
-   Composer - PHP dependency manager.
-   MySQL 5.6 - Database server.

## Installation

1. Clone the repository:

    ```bash
    git clone https://github.com/yourusername/yourproject.git
    ```

2. Navigate to the project directory:

    ```bash
    cd yourproject
    ```

3. Install PHP dependencies using Composer:

    ```bash
    composer install
    ```

4. Create a copy of the `.env.example` file and rename it to `.env`:

    ```bash
    copy .env.example .env
    ```

5. Generate the application key:

    ```bash
    php artisan key:generate
    ```

6. Configure your database connection in the `.env` file.

## Running Migrations

1.a To set up the database schema, run the following command:

```bash
php artisan migrate
```

1.b (Optional) To set up the database schema with drop existing table and, run the following command:

```bash
php artisan migrate:fresh
```

2. (Optional) To set up the database schema with drop existing table and, run the following command:

```bash
php artisan db:seed
```

## Running server

You can serve the application using the built-in PHP development server or any other server of your choice.

```bash
php artisan serve
```
