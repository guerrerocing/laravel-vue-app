
# Delivery App

This is an app that I usually work on in my free time, basically you can add Stores, Products and order products.


## Tech Stack

**Client Side:** Vue, Vue-Apollo, Vue-Router, ElementPlus

**Server Side:** PHP, Laravel, PHP-LightHouse(GraphQL)


## Run Locally

Clone the project

```bash
  git@github.com:guerrerocing/laravel-vue-app.git
```

Go to the project directory

```bash
  cd laravel-vue-app
```

Install dependencies


```bash
  yarn install
```



Make sure you don't have Postgres, PHP, or NGINX instances running.

create .env file

```bash
  cp .env.example .env
```
Running Docker
```bash
  docker-compose up --build -d
```
Go to container
```bash
  docker exec -it Laravel_php /bin/sh
```


## Install dependencies


```bash
  composer install

  php artisan key:generate

  php artisan migrate
  
  composer ide-helper
```

## Running FrontEnd

Make sure you are outside our container but inside our project and run:

```bash
yarn dev
```

Now we can access our project in our browser
```
http://localhost:8000
```
## API Reference

#### GraphQL API

GraphQL Documentation with queries
& mutations.

```http
  http://localhost:8000/graphiql
```

#### GraphQL Endpoint

```http
  http://localhost:8000/graphql
```

###Backend Directories

```
/App/GrahpQL

/graphql

/Models
```

###Vue Directory

```
/resourses/vue-app
```






