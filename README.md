## API Users & Clients

This API provides functionality to manage users and client APIs using a MySQL database. Features include:

### Users
- Retrieve all users.  
- Create a new user.  
- Delete a user.  
- Authenticate users with JWT.  
- Logout a user.  
- Refresh a JWT token.

### Client APIs
- Retrieve all client APIs.  
- Create a new client API.  
- Delete a client API.  
- Authenticate client APIs with JWT.  
- Logout a client API.  
- Refresh a JWT token.

## Dockerization

This API supports Dockerization and includes two Dockerfiles:  
- **Dockerfile.base**: Contains the operating system, web server, PHP, Nginx, and other required software and extensions. This serves as the base image for the OS layer.  
- **Dockerfile**: Contains additional extensions and Laravel installation.

How to run:
- Build the Docker image:
    <br/><code>docker build . -t be-app</code>
- Run the container:
    <br/><code>docker run -p 1234:80 --name=be -d -t be-app</code>


## Unit Test

Yes, this API supports unit testing using php artisan test. It includes four test classes covering multiple scenarios:

### AuthTest
Commands: <code>php artisan test --filter AuthTest</code>
- A user can log in and receive a JWT token.
- A user can log out.
- A user can refresh their JWT token.

### AuthClientTest
Commands: <code>php artisan test --filter AuthClientTest</code>
- A client API can log in and receive a JWT token.
- A client API can log out.
- A client API can refresh its JWT token.

### UserTest
Commands: <code>php artisan test --filter UserTest</code>
- A user can create a new user.
- A user can retrieve all users.
- A user can retrieve a user by ID.
- A user can delete a user.

### ClientApiTest
Commands: <code>php artisan test --filter ClientApiTest</code>
- A client API can create a user.
- A client API can retrieve all client APIs.
- A client API can retrieve a client API by ID.
- A client API can update a client API.
- A client API can delete a client API.

## Postman Collection
It also comes with a Postman collection.

## Spesification
This API is built with the following tech stack:
- Laravel 12, following a layered architecture:
    1. Controller - Handles requests and validation.
    2. Service - Implements business logic.
    3. Repository - Manages data persistence.
- PHP 8.4
- MySQL 8

## Standardization of API Response
This API follows a standardized response format to ensure consistency. The response includes the following fields:
- <code>status</code>
- <code>code</code>
- <code>message</code>
- <code>timestamp</code>
- <code>data</code>

Beside that, it also came with standar of HTTP code, with the following:
- <code>200</code> - Success
- <code>201</code> - Successfully created
- <code>404</code> - Not found
- <code>400</code> - Bad request (failure)
- <code>401</code> - Unauthorized
- <code>403</code> - Forbidden access
- <code>500</code> - Internal server error