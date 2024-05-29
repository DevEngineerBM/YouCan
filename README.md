# Laravel Vue.js Application

This is a Laravel application with a Vue.js 3 frontend.

## Table of Contents

-   [Prerequisites](#prerequisites)
-   [Installation](#installation)
-   [Configuration](#configuration)
-   [Running the Application](#running-the-application)
-   [Running Tests](#running-tests)
-   [Commands](#commands)
-   [License](#license)

## Prerequisites

Before you begin, ensure you have met the following requirements:

-   PHP = 7.4
-   laravel 6
-   Composer
-   Node.js & NPM
-   MySQL

## Installation

To install and set up the application, follow these steps:

1. **Clone the repository:**

    ```bash
    git clone https://github.com/DevEngineerBM/YouCan.git
    cd YouCan
    ```

2. **Install PHP dependencies:**

    ```bash
    composer install
    ```

3. **Install JavaScript dependencies:**

    ```bash
    npm install
    ```

4. **Copy the `.env.example` file to `.env`:**

    ```bash
    cp .env.example .env
    ```

## Configuration

1. **Generate the application key:**

    ```bash
    php artisan key:generate
    ```

2. **Set up the database:**

    Open the `.env` file and update the following lines with your database credentials:

    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=your_database_name
    DB_USERNAME=your_database_user
    DB_PASSWORD=your_database_password
    ```

3. **Run the database migrations:**

    ```bash
    php artisan migrate
    ```

## Running the Application

1. **Build the front-end assets:**

    ```bash
    npm run dev
    ```

2. **Start the development server:**

    ```bash
    php artisan serve
    ```

    The application will be available at `http://localhost:8000`.

## Running Tests

To run the Product creation Test.

```bash
Vendor/Bin/Phpunit
```

## Commands

### Creating a Product

To create a product via the command line, use the `product:create` command:

```bash
php artisan product:create {name} {description} {price} {--category_ids=*}
```

make sure the category_id exists in database,
