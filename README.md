## API Users & Clients

This API have some functionality to manage users and client APIs with MySQL database, such as:

### Users
- Get all users.
- Create new user.
- Delete a user.
- Login user with JWT authentication.
- Logout user.
- Refresh JWT token.

### Client APIs

- Get all client APIs.
- Create new client API.
- Delete a client API.
- Login client API with JWT authentication.
- Logout client API.
- Refresh JWT token.

## Dockerization

This API supports dockerization and comes with two dockerfile:
- <b>Dockerfile.base</b>, which consist of operating system, webserver, PHP, nginx, and other relative software and extension. This will make a docker image base for OS layer.
- <b>Dockerfile</b>, which consist of extension and laravel installation.

How to run:
- Build Dockerfile first with commands:
    <br/><code>docker build . -t be-app</code>
- Run, Forrest, Run!
    <br/><code>docker run -p 1234:80 --name=be -d -t be-app</code>


## Unit Test

Yes, this API can doing unit test too which supported by <b>php artisan test</b>. There are four unit tests with several scenarios, such as:

### AuthTest
Commands: <code>php artisan test --filter AuthTest</code>
- User can login and get JWT token.
- User can logout.
- User can refresh token.

### AuthClientTest
Commands: <code>php artisan test --filter AuthClientTest</code>
- Client API can login and get JWT token.
- Client API can logout.
- Client API refresh token.

### UserTest
Commands: <code>php artisan test --filter UserTest</code>
- User can add user.
- User can get all users.
- User can get user by id.
- User can delete user.

### ClientApiTest
Commands: <code>php artisan test --filter ClientApiTest</code>
- Client API can add user.
- Client API can get all client apis.
- Client API can get client api by id.
- Client API can update client api.
- Client API can delete client api.

## Postman Collection
If you need Postman Collection, please, don't hesitate to contact me.