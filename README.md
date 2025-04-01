# UserManager

An application for creating and managing users through a REST API.

## Description

UserManager is an application for generating fake users and managing them through a REST API. The application is built with Laravel and provides an interface for creating users with authorization tokens. Initially, users can be automatically generated, and then new users can be created and managed using the API. Custom tokens are used for user authentication, which are generated and stored in the database.

## Technologies

- **Laravel** – PHP framework for server-side development.
- **MySQL** – Database for storing user information.
- **Custom Authentication Tokens** – For user authentication via tokens.
- **Postman** – For testing the API.

## Installation

### Requirements

Before setting up the project, make sure you have the following installed on your machine:

- **PHP** >= 8.1
- **Composer** – PHP package manager
- **MySQL** – Database for storing user information
- **Node.js** and **NPM** – For managing frontend dependencies
- **ext-gd** – PHP extension for image manipulation (required for image uploads)
- **GuzzleHTTP** – HTTP client for making HTTP requests
- **Tinify** – For image compression (optional)

### Installation Steps

1. Clone the repository:

    ```bash
    git clone https://github.com/Scream123/UserManager.git
    cd UserManager
    ```

2. Install PHP dependencies using Composer:

    ```bash
    composer install
    ```

3. Install Node.js dependencies (for frontend and assets):

    ```bash
    npm install
    ```

4. Install required PHP extensions if not already installed:
    - **ext-gd**: For image processing functionality
    - **GuzzleHTTP**: For making HTTP requests
    - **Tinify** (optional): For image compression during uploads

5. Set up the environment file by copying the example:

    ```bash
    cp .env.example .env
    ```

6. Generate the application key:

    ```bash
    php artisan key:generate
    ```

7. Configure your database connection in the `.env` file.

8. Run database migrations:

    ```bash
    php artisan migrate
    ```

9. (Optional) If you want to seed the database with some sample data, run:

    ```bash
    php artisan db:seed
    ```

10. Start the Laravel development server:

    ```bash
    php artisan serve
    ```

Now your application should be running at [http://localhost:8000](http://localhost:8000).

### Testing the API

To test the API, you can use **Postman** or any other API testing tool. You will need to generate an authentication token and include it in the request headers.

Example of API request with token:

```bash
Authorization: Bearer YOUR_TOKEN_HERE
