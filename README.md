# Chat Api Application

This is an api for sending and receiving messages between users.

## Prerequisites

Dev installation requires docker https://docker.com

## Running

To run the application, navigate to the root of the directory and run

docker-compose up -d

This will bring up the code and database as needed.

Once that completes, you can access the api locally using the url

http://localhost:8080/api/users

## Swagger Documentation

Documentation of the api can be seen at http://localhost:8080/swagger/index.html

## Database seeding

If you want a database seeded with test data, you can run

docker-compose exec app | php artisan db:seed


