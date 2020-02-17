# Rest API Maju Mundur with Laravel and MongoDB

## Description
Have 3 roles user : Superuser (```super```), Merchant (```merchant```) and Customer (```customer```).

## Requirement
Install ```mongodb``` on your system (``` apt-get ``` or the like) and don't try to install with ```pecl```:
```bash
sudo pecl install mongodb
```

## Installation

Install package with ```composer``` :

```bash
composer install
```

Migrate Table or Collections:
```bash
php artisan migrate
```

Add dummy data with seeder:
```bash
php artisan db:seed
```
```Superuser :```
username : ```super```
```Merchant :```
username : ```merchant1```
username : ```merchant2```
```Customer :```
username : ```customer1```
username : ```customer2```

password : ```123```


For reset data :
```bash
php artisan migrate:refresh --seed
```