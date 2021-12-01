# Hello World API: Laravel + PHP Sample

You can use this sample project to learn how to secure a simple Laravel API server using Auth0. This guide is for Laravel 8.0+ running on PHP 7.3+

The `starter` branch offers a working API server that exposes three public endpoints. Each endpoint returns a different type of message: public, protected, and admin.

The goal is to use Auth0 to only allow requests that contain a valid access token in their authorization header to access the protected and admin data. Additionally, only access tokens that contain a `read:admin-messages` permission should access the admin data, which is referred to as [Role-Based Access Control (RBAC)](https://auth0.com/docs/authorization/rbac/).

[Check out the `add-authorization` branch](https://github.com/yemiwebby/api-server-laravel/tree/add-authorization) to see authorization in action using Auth0.

[Check out the `add-rbac` branch](https://github.com/yemiwebby/api-server-laravel/tree/add-rbac) to see authorization and Role-Based Access Control (RBAC) in action using Auth0.


## Get Started

This repository assumes you have a working Laravel environment, and that you can start a Laravel application server. Depending of the way you installed it this process might differ. However, you will generally follow one of these methods:

- *Using Laravel Sail:* In this case, you will have your environment and dependencies ready to go for your Laravel app through a docker container, and won't have to install them manually.

- *Installing Laravel through composer:* If you have PHP and composer installed globally, you can also run this application through the `artisan` executable in the project's root directory

For general Laravel installation information you can read [this article](https://laravel.com/docs/8.x/installation).

### Install the project's dependencies

The dependencies needed by this example are already included with Laravel and handled with the Composer package manager. Composer makes it easy to manage your direct dependencies through a `composer.json` file, and freezes the required versions for all dependencies through the `composer.lock` file. You can find more information for composer [in this link](https://getcomposer.org/doc/00-intro.md).

To install the required project dependencies run the following command.

```bash
composer install
```

This will pull the Laravel framework and its own dependencies into the environment, allowing you to use them.

### Set up your environment

Navigate to the base directory of this repo and generate an environment configuration file (`.env`). Laravel reads this information from the file through the `phpdotenv` library, included with the framework. We've provided a sample file that you can copy and tweak as needed. Usually, fresh Laravel installations have a lot of environment variables set that configure most of the included services, however, you will find that the example environment file we've provided is a lot leaner. It has the exact required variables to run a simple API server.

```bash
cp .env.example .env
```

The `.env.example` file will contain default values, which you can use out of the box to integrate with compatible client applications in the future. However, feel free to change them as needed directly in the .env file.

### Generate the app key

Before starting the application you need to generate an application key. This is done through artisan with the following command:

```bash
./vendor/bin/sail artisan key:generate

# or, if you installed with composer...

php artisan key:generate
```

This command will generate a key directly on the `.env` file of your application, which will allow you to start the server.

### Start your Laravel application

This step will differ a little bit depending on your Laravel installation method

```bash
./vendor/bin/sail up

# or, if you installed with composer...

php artisan serve
```

## API Endpoints

The API server defines the following endpoints:

### 🔓 Get public message

```bash
GET /api/messages/public
```

#### Response

```bash
Status: 200 OK
```

```json
{
  "message": "The API doesn't require an access token to share this message."
}
```

### 🔓 Get protected message

> You need to protect this endpoint using Auth0.

```bash
GET /api/messages/protected
```

#### Response

```bash
Status: 200 OK
```

```json
{
  "message": "The API successfully validated your access token."
}
```

### 🔓 Get admin message

> You need to protect this endpoint using Auth0 and Role-Based Access Control (RBAC).

```bash
GET /api/messages/admin
```

#### Response

```bash
Status: 200 OK
```

```json
{
  "message": "The API successfully recognized you as an admin."
}
```

## Error Handling

### 400s errors

#### Response

```bash
Status: Corresponding 400 status code
```

```json
{
  "message": "Message that describes the error that took place."
}
```

### 500s errors

#### Response

```bash
Status: 500 Internal Server Error
```

```json
{
  "message": "Message that describes the error that took place."
}
```

## Additional information

### HTTP Security Headers

Security headers are being set through the `\App\Http\Middleware\HttpHeaders` middleware. Please refer to that file to check the recommended secure values based on the [OWASP Secure Headers Project](https://owasp.org/www-project-secure-headers/#div-headers).

### CORS

CORS configuration is being done through the `\Fruitcake\Cors\HandleCors` middleware. Its recommended secure values can be found in `app/config/cors.php`. These values are very specific and enable a high security level on the application by restricting cross-domain API calls.
