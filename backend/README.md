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
        "php": "^8.1",
        "guzzlehttp/guzzle": "^7.2",
        "laravel/framework": "^10.10",
        "laravel/sanctum": "^3.3",
        "laravel/tinker": "^2.8",
        "laravel/ui": "^4.2",
        "spatie/laravel-medialibrary": "^10.4.4"
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

# Redis Configuration (Using Redis Labs)

This project uses Redis to cache database queries and improve performance. Redis is configured using Redis Labs (Redis Cloud), which works even on shared hosting environments.

1. Create a Redis Labs Account

Sign up at https://redislabs.com/ and create a free Redis database instance.

2. Install Redis Client in Laravel

Laravel supports both phpredis and predis. For cloud Redis, Predis is recommended:

    composer require predis/predis

3. Update the .env file with Redis Labs credentials:

    CACHE_DRIVER=redis
    SESSION_DRIVER=redis
    QUEUE_CONNECTION=redis
    
    REDIS_CLIENT=predis
    REDIS_HOST=your_redis_host
    REDIS_PASSWORD=your_redis_password
    REDIS_PORT=6379
    REDIS_DB=0
    REDIS_CACHE_DB=1
    
    
    #REDIS_DB → default database for general use
    #REDIS_CACHE_DB → database for caching

4. Verify Redis Config in **config/database.php**

Make sure Laravel's Redis configuration matches your .env:

    'redis' => [
	    'client' => env('REDIS_CLIENT', 'predis'),
	    'default' => [
	    'host' => env('REDIS_HOST', '127.0.0.1'),
	    'password' => env('REDIS_PASSWORD', null),
	    'port' => env('REDIS_PORT', 6379),
	    'database' => env('REDIS_DB', 0),
    ],
    'cache' => [
	    'host' => env('REDIS_HOST', '127.0.0.1'),
	    'password' => env('REDIS_PASSWORD', null),
	    'port' => env('REDIS_PORT', 6379),
	    'database' => env('REDIS_CACHE_DB', 1),
    ],



5. Test Redis Connection  

Use Laravel Tinker to verify connectivity:

    php artisan tinker

    Cache::put('test_key', 'Hello Redis Labs', 300); // cache for 5 minutes
    Cache::get('test_key'); // returns 'Hello Redis Labs'

6. Cache Database Queries

Example: Caching all users for 10 minutes:


    use Illuminate\Support\Facades\Cache;

    use App\Models\User;

    $users = Cache::remember('users.all', 600, function () {
			return User::all();
	});



First request fetches data from the database. Subsequent requests read data from Redis cache.

# Redis Notes


- Redis Labs is ideal for shared hosting where you cannot install Redis locally.
- Free Redis Labs tier is sufficient for development and small production workloads.
- Always ensure CACHE_DRIVER=redis and SESSION_DRIVER=redis in production .env.