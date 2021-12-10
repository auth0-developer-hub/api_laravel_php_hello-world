# Hello World API: Laravel + PHP Sample

This branch uses the [Auth0 PHP SDK](https://github.com/auth0/auth0-php) to implement authorization for two of the three endpoints built in the [starter](https://github.com/auth0-developer-hub/api_laravel_php_hello-world/tree/starter) branch. In summary:

- The `GET /api/messages/protected` and `GET /api/messages/admin` branches will be protected against unauthorized access. For this, you need to send a valid access token in the request header.

- The `GET /api/messages/public` endpoint will still be unsecured.

For a Role-Based access control please [Check out the `add-rbac` branch](https://github.com/auth0-developer-hub/api_laravel_php_hello-world/tree/add-rbac) to see authorization and Role-Based Access Control (RBAC) in action using Auth0.


## Get Started

### Set up your environment

Generate the .env file by running the following command.

```bash
cp .env.example .env
```
Feel free to change the values as needed directly in the .env file. For the AUTH0_AUDIENCE and AUTH0_DOMAIN values, please check out the "Register your API" section below.

As a second step, please install the project's dependencies

```bash
composer install
```

Finally, generate an APP_KEY:

```bash

# If you're running the project using Sail

./vendor/bin/sail artisan key:generate

# or, if you installed with composer...

php artisan key:generate
```

### Register your API

Create a free account in Auth0, and log into the dashboard. From this point, follow these steps to set up your API:

- Click on Applications -> APIs on the Dashboard sidebar.

- Click on **Create API**, and fill out the required fields. You can use the following sample data or provide your own:
  - Name: _Hello World API Server_.
  - Identifier: http://my.hello-world.server
  - Signing Algorithm: RS256

- Click on **Create**.

For more information on this part, please check out ["Register APIs"](https://auth0.com/docs/get-started/set-up-apis).

As a next step, let's get the value for `AUTH0_AUDIENCE`

- Click on Applications -> APIs on the Dashboard sidebar, and click on the API you created in the previous step
- Click on the Settings tab
- Get the `Identifier` field's value and use it for the `AUTH0_AUDIENCE` in your `.env` file

Finally, let's get the `AUTH0_DOMAIN` value with the following steps:

- Click on Applications -> APIs on the Dashboard sidebar, and click on the API you created in the previous step
- Click on the Test tab, and then on the cURL tab below if it's not selected
- Copy the value from the `--url` parameter in the sample POST request, not including the `https://` or `/oauth/token` parts (for example, if the `--url` complete value is `https://dev-abcdefg.us.auth0.com/oauth/token`, just copy the `dev-abcdefg.us.auth0.com` part). Use this value for the `AUTH0_DOMAIN` in your `.env` file

### Start your Laravel application

This step will differ a little bit depending on your Laravel installation method

```bash

# If you're running the project using Sail

./vendor/bin/sail up

# or, if you installed with composer...

php artisan serve
```

### Test the endpoints

Once the server is up, you will be able to test your protected endpoints. You can check the following steps:

- Click on Applications -> APIs on the Dashboard sidebar, and click on the API you created in the previous step
- Click on the Test tab, and then on the cURL tab below if it's not selected
- Copy the cURL string and replace the `--url` parameter with your local protected endpoint. Please do not change the bearer token


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
  "text": "The API doesn't require an access token to share this message."
}
```

> 🔐 Protected Endpoints: These endpoints require the request to include an access token issued by Auth0 in the authorization header.

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
  "text": "The API successfully validated your access token."
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
  "text": "The API successfully recognized you as an admin."
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
  "text": "Message that describes the error that took place."
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



## [Optional] Add Cache to Your Project

For performance reasons, [Auth0 PHP SDK](https://github.com/auth0/auth0-php) supports (and recommends) using a [PSR-6 Compatible Caching Library](https://www.php-fig.org/psr/psr-6/). The library will be used to temporarily store [JWKS](https://auth0.com/docs/security/tokens/json-web-tokens/json-web-key-sets) public keys. Adding this cache layer avoids making a request to `AUTH0_DOMAIN` everytime you need to verify a token.

To add cache to this project, you'll need to do the following:

1. Add [`symfony/cache`](https://symfony.com/doc/current/components/cache.html) dependency:
    ```bash
    composer require symfony/cache
    ```
    This library is required because it provides an [adapter](https://symfony.com/doc/current/components/cache/psr6_psr16_adapters.html) needed to wrap [Laravel's cache](https://laravel.com/docs/8.x/cache) as a PSR-6 compatible interface required by Auth0 PHP SDK.

2. The default driver for cache in Laravel is the `file` driver. If you want to use a different driver, set it up on your env file:
    ```bash
    CACHE_DRIVER=<driver>
    ```
    Laravel supports a wide variety of the cache drivers. Please refer to its [documentation](https://laravel.com/docs/8.x/cache) for more details.
3. Add `useCache` to enable cache for Auth0 on `config/auth0.php`:
    ```php
    <?php
    return [
        'domain' => env('AUTH0_DOMAIN'),
        'audience' => [ env('AUTH0_AUDIENCE') ],
        'useCache' => true // Add this line
    ];
    //...
    ```
4. Reload your configuration:
    ```bash
    php artisan config:cache
    ```

## Code Sample Specs
This code sample uses the following main tooling versions:

- Laravel v8.75.0
- PHP v7.4.25
- Auth0 PHP SDK v8.0.3

The Laravel project dependency installations were tested with Composer v2.1.14.
