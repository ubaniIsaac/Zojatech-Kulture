# Kulture API

Welcome to the Kulture API documentation. This API is designed to provide music producers and artists with a platform to interact with beats. Producers can perform CRUD (Create, Read, Update, Delete) operations on beats, while artists can purchase beats from the platform.

## Live Link
You can access the live version of the Kulture API at [https://kulture-api.onrender.com/api/v1](https://kulture-api.onrender.com/api/v1)

## API Documentation
The API documentation can be found at [https://documenter.getpostman.com/view/10737800/TzXtJz5V](https://documenter.getpostman.com/view/20573715/2s9Y5crzch)

## API Documentation (Local)
The API documentation can be found at [http://localhost:8000/api/documentation](http://localhost:8000/api/documentation)

## Docker Image Link
For Docker deployment, you can use the following image link: `07fffffffffffffffffffff`

## Requirements

- PHP 7.3+
- Composer
- Laravel 7+
- MySQL 5.7+
- Docker (Optional)

## Deployment

- Clone the repository with the command `git clone`
- `cd` into the project directory
- Run `composer install` to install the project dependencies
- Create a database for the application
- Copy the `.env.example` file and rename it to `.env`
- Update the `.env` file with your database credentials
- Run `php artisan migrate` to migrate the database
- Run `php artisan serve` to start the application

## Deployment (Docker)

- Clone the repository with the command `git clone`
- `cd` into the project directory
- Run `docker-compose up -d --build` to build the docker containers
- Run `docker-compose exec app php artisan migrate` to migrate the database
- Run `docker-compose exec app php artisan serve` to start the application


## Testing

- Run `php artisan test` to run the tests.

## Key Features

### Users (`Producers Only`)
- Can Perform `CRUD operations on beats`.
- Producers can set the number of beat copies available for purchase.

### Users (`Artistes Only`)
- Can `Purchase` Beats.
- Can listen to `demo` version of beats.
- Can Only `download purchased beats` (download locally or send to email).
- Purchased Beats are available for downloads always.
- Can `Flag beats`.

### Beats Model
- Beats Flagged by more than 10 users will be set to `under-review`.
- Beats `under-review` cannot be seen by users.

### Subscription Model
- Free Users (Producers) can only `upload a max. of 5 beats`.
- Free Users (Artists) can only `listen to a max. of 5 beats`.
- Referred Users from an existing user can `upload/listen` to a max. of 10 beats.
- When Users referral codes are used, users' `upload/listen` limit is increased by 5.

### Advanced Features
- Users can only login to the web app with `one device at a time`.
- When new devices are detected, `Users are notified`.
- Beats `under review` require two admin approvals before the flag can be removed.

## API Endpoints

### Beats

- GET `/api/v1/beats` - Get all beats
- GET `/api/v1/beats/{id}` - Get a single beat
- POST `/api/v1/beats` - Create a beat
- PATCH `/api/v1/beats/{id}` - Update a beat
- DELETE `/api/v1/beats/{id}` - Delete a beat

### Purchases

- GET `/api/v1/purchases` - Get all purchases
- GET `/api/v1/purchases/{id}` - Get a single purchase
- POST `/api/v1/purchases` - Create a purchase
- PATCH `/api/v1/purchases/{id}` - Update a purchase
- DELETE `/api/v1/purchases/{id}` - Delete a purchase


### ADMIN

## Flag
- GET `/api/v1/admin/flagged-beats` - Get all flagged beats
- GET `/api/v1/admin/flagged-beats/{id}` - Get a single flagged beat
- POST `/api/v1/admin/flagged-beats` - Create a flagged beat
- PATCH `/api/v1/admin/flagged-beats/{id}` - Update a flagged beat
- DELETE `/api/v1/admin/flagged-beats/{id}` - Delete a flagged beat

## Purchases
- GET `/api/v1/admin/purchases` - Get all purchases
- GET `/api/v1/admin/purchases/{id}` - Get a single purchase
- POST `/api/v1/admin/purchases` - Create a purchase
- PATCH `/api/v1/admin/purchases/{id}` - Update a purchase
- DELETE `/api/v1/admin/purchases/{id}` - Delete a purchase

## Beats
- POST `/api/v1/admin/beats/{id}/approve` - Approve a flagged beat
- POST `/api/v1/admin/beats/{id}/reject` - Reject a flagged beat
- GET `/api/v1/admin/beats` - Get all beats
- GET `/api/v1/admin/beats/{id}` - Get a single beat
- POST `/api/v1/admin/beats` - Create a beat
- PATCH `/api/v1/admin/beats/{id}` - Update a beat
- DELETE `/api/v1/admin/beats/{id}` - Delete a beat


## Users
- GET `/api/v1/users` - Get all users
- GET `/api/v1/users/{id}` - Get a single user
- PATCH `/api/v1/users/{id}` - Update a user
- DELETE `/api/v1/users/{id}` - Delete a user
- POST `/api/v1/admin/users/{id}/approve` - Approve a user
- POST `/api/v1/admin/users/{id}/reject` - Reject a user

## Subscriptions

- GET `/api/v1/admin/subscriptions` - Get all subscriptions
- GET `/api/v1/admin/subscriptions/{id}` - Get a single subscription
- POST `/api/v1/admin/subscriptions` - Create a subscription
- PATCH `/api/v1/admin/subscriptions/{id}` - Update a subscription
- DELETE `/api/v1/admin/subscriptions/{id}`

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
