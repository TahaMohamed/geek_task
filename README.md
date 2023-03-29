# Geeks Task

Laravel Task instructions:

### Ads Attributes:
- Install a fresh Laravel Project. 
- Create 3 table migrations countries, cities,and areas. Please add columns as you see fit. (Use foreign keys if necessary).
- Create all needed relations in the model.
- Install PassportPackage with the necessary setup.
- Create API CRUDS (create, read, update and delete) for countries and cities with the appropriate routes.
- Createan API that gets a country'scities by country id. (Please use Laravel relationsand conventions).
- Please create a Postman file with all required APIs.
### Endpoints should contain:
- Country (CRUD)
- Area (CRUD)
- City filters (by country)

## Installation

1. Clone the repo and `cd YOUR-PROJECT` into it.
1. `composer install`.
1. Rename or copy `.env.example` file to `.env`.
1. Set database credentials in `.env` file.
1. `php artisan migrate --step`.
1. `php artisan serve`.
1. To watch requests that sent to server go to `localhost:8000/telescope`
1. Use [Postman Collection](https://documenter.getpostman.com/view/6784299/2s93RRvsuR) for run api services

## Tesing
- Run `php artisan test --filter test_add_city`.
   
