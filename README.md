# microservice login based on Docker, PHP, Symfony framework and flex
***
registration and login and data info API.

I build this microservice inside Docker (https://www.docker.com/)



## Table of Contents
1. [General Info](#general-info)
2. [Technologies](#technologies)
3. [Installation](#installation)
4. [Collaboration](#collaboration)
5. [FAQs](#faqs)


## General Info
***
The project consists of three routes
- register
- login
- user data

get data from user and save in database , create a user and return form-error if submitted form has any error.
and then user can login in route login_check and system return jwt token and user id in uuid type and status .
now user can get data in rote userdata .

## Documentions :
 https://documenter.getpostman.com/view/10153663/UVknuGty


## Technologies
***
A list of technologies used within the project:
* [php](https://www.php.net/): Version 7.4
* [symfony](https://symfony.com/): Version 5.4
* [docker](https://www.docker.com/): Version 20.10
* [jwt](https://github.com/lexik/LexikJWTAuthenticationBundle): Version 2.14
* [rest](https://github.com/FriendsOfSymfony/FOSRestBundle): Version 3.3
* [serializer](https://github.com/schmittjoh/JMSSerializerBundle): Version 4.0


## Installation
***
A little intro about the installation.

## Running and Deployment :

for running this project in your local environment you can use below command :

### Runinng Docker:

```
docker-compose  up -d
```

### PHP Dependencies:   

please run below command inside of php container:

```
cd ]co/
composer install 
```

### CREATE DB SCHEMA:

please run below command inside of php container:
```
cd survey/
./bin/console make:migration
./bin/console doctrine:migrations:migrate
```

you can check database schema with phpMyadmin by this URL: 
http://localhost:6973/

Credentials | USER | Password
 --- | --- | ---
 Root | product_user | product_pass


