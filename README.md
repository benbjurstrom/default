## Overview
Default provides an opinionated [Laravel](https://laravel.com/) / [Nuxt](https://nuxtjs.org/) boilerplate for rapid prototyping of API backed Single Page Applications. Everything you need for authentication and administration is preconfigured to work with a simple docker-compose up command.

## Quickstart
Clone this repo into new project folder
```shell
git clone https://github.com/benbjurstrom/default.git  default
cd default
```
Run the installer
```shell
./install.sh
```

Start the docker containers
```shell
docker-compose up
```

For the client view navigate to http://localhost:3000 and login with user@test.com. For the administrator view navigate to http://localhost:8001 and login with admin@test.com.

## Overview
At the root of the project you will find the following file structure
├── api

├── client

├── docker

├── docker-compose.yml

└── install.sh


### Api
Within the api folder is a preconfigured [Laravel](https://laravel.com/) install with  API endpoints added for login, registration, and password management.

The Laravel install is wired up to a postgres database using UUIDs as the primary keys. API authentication is handled using the [jwt-auth](https://jwt-auth.readthedocs.io) package.

This folder also provides the code for a separate administrator docker container. The administrator container runs preconfigured instances of [Horizon](https://horizon.laravel.com/) and its queue workers,  a cron heartbeat for dispatching scheduled jobs, and [Telescope](https://laravel.com/docs/5.8/telescope).

### Client
Within the client folder is a preconfigured [Nuxt](https://nuxtjs.org/) installation with user interfaces added for registration, authentication, and password management.

The styling is provided by [Buefy](https://buefy.org) which is a thin Vuejs wrapper around [Bulma](https://bulma.io).

Authentication is preconfigured to work with the API using the [Nuxt Auth](https://auth.nuxtjs.org/) module.

An [Axios](https://github.com/axios/axios) plugin is configured to automatically display [loading indicators](https://buefy.org/documentation/loading), error message, and [form validation errors](https://buefy.org/extensions/veevalidate) using [vee-validate](https://baianat.github.io/vee-validate/).

## Why
Popular frameworks like Laravel and Nuxt need to remain flexible to accommodate a wide range of use cases.  Therefore, even though they provide enormous value there is still a fair amount of boilerplate that needs to be added to get your project off the ground.

Many times I have started prototyping an idea only to see my enthusiasm fizzle once I got to the point where I needed to setup password reset capability, terms of service agreements, and dev-ops infrastructure. With Default the goal is to have all of those details in place in advance so I can stay focused on the project details.
