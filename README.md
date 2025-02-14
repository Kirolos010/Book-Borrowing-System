# Book Borrowing System

This is a Laravel-based Book Borrowing System. Follow these steps to set up the project on your local machine.

## Features

- **User&Admin Registration & Login**
- **dashboard & website**
- **Ajax when user borrow book**
- **user can export a book details as a PDF**
- **UI Authentication**
- **Book Management (CRUD)**: Create, read, update, and delete book , borrow
- **Roles & Permissions using spatie library**
- **filterition**
- **User-friendly UI**

## Prerequisites

Ensure you have the following installed:
- PHP (>= 8.1)
- Composer
- MySQL
- Node.js & npm (for frontend assets)
- Git

## Installation

1. **Install PHP dependencies via Composer:**

    ```bash
    composer install
    ```

2. **Copy `.env.example` to create a new `.env` file:**

    ```bash
    cp .env.example .env
    ```

3. **Open `.env` and configure your database settings:**

    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=your_database_name
    DB_USERNAME=your_database_username
    DB_PASSWORD=your_database_password
    ```

4. **Generate an application key:**

    ```bash
    php artisan key:generate
    ```

5. **Run migrations to create the database tables:**

    ```bash
    php artisan migrate
    ```
6. **Run Seeder for Admins accounts and randoms books**

    ```bash
    php artisan db:seed
    ```
7. **For generate files**

    ```bash
   php artisan storage:link  
    ```
8. **Install frontend dependencies using npm:**

    ```bash
    npm install
    ```

9. **Compile frontend assets:**

    ```bash
    npm run dev
    ```

10. **Start the development server:**

    ```bash
    php artisan serve
    ```
---

Your application should now be accessible at `http://localhost:8000`.
