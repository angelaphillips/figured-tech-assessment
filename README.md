## Overview

This is a simple Laravel application that calculates the $ valuation of a given 
number of units of an inventory by using the first in first out valuation method.

The application uses Bootstrap 5 for some simple styling and Axios for a simple http request. 

<img width="1427" alt="Screenshot 2022-10-24 at 23 02 18" src="https://user-images.githubusercontent.com/44080152/197633802-f3a61b3a-3680-4d80-9360-562187f168b3.png">


## Installation 

If not already installed, please download [Docker desktop](https://www.docker.com/products/docker-desktop/) to run the application.

## To run the application

Navigate to the root directory of the application

`cd figured-tech-assessment`

Run composer install
`composer install`

Run the docker container 

`./vendor/bin/sail up -d`

Compile front-end assets

`npm install`

`npm run build`

Run the database migrations

`docker exec -it figured-tech-assessment-laravel.test-1 php artisan migrate`

Seed the database with the test data 

`docker exec -it figured-tech-assessment-laravel.test-1  php artisan db:seed`

Browse to http://localhost/

## To run tests

`./vendor/bin/sail test`

## Thank you for reviewing



