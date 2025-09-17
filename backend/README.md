# Portfolio and Personal CRM for Freelancers - Fullstack Application (Laravel)

This is the Laravel backend for the project. It provides a REST API that powers the frontend, handling authentication, CRUD operations, and data persistence.

 # Tech Stack

- Laravel v11+
- PHP v8.2+
- MySQL - Database
- Composer - Dependency management
- Sanctum - Authentication layer

# Dependencies

The project's PHP dependencies are managed by Composer. To install them, navigate to the backend directory and run:

    composer install

The primary dependencies, as listed in composer.json, include:

    "require": {
	    "php": "^8.2",
	    "laravel/framework": "^11.0",
	    "laravel/sanctum": "^4.0"
    }


# Installation and Setup

1. Navigate to the backend directory:

    cd backend

2. Configure environment variables:

Copy the example environment file and create your own .env file:

    cp .env.example .env

Open the newly created .env file and update your database credentials:

    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=your_db_name
    DB_USERNAME=your_username
    DB_PASSWORD=your_password

3. Generate the application key:
  
    php artisan key:generate

4. Run database migrations:

    php artisan migrate

5. Serve the backend:

    php artisan serve

The API will be available at http://127.0.0.1:8000


# Features

- REST API for frontend communication.
- Modules for certifications and projects.
- Authentication handled by Sanctum.
- Built-in validation for data security.

# Notes

Ensure your MySQL or PostgreSQL database is running and accessible.

Remember to configure CORS (Cross-Origin Resource Sharing) to allow requests from your frontend application.

The API's base route is http://localhost:8000/api