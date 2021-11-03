# docker-laravel

### versions
```
- PHP:  7.4.22 
- Nginx: 1.18.0
- Mysql: 8.0.26
```

### crete laravel project and set up
```
1. $ git clone this repository
2. $ cd docker-laravel

3. $ cp .env.template .env
4. $ make create-project
5. $ make init
6. edit db info and app_url on backend/.env file

APP_URL=http://localhost:8080

DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=kredo_laravel
DB_USERNAME=kredo
DB_PASSWORD=password

8. $ make migrate
```

### into container
```
# php container
$ make app

# db container
$ make db

# how to into mysql on db continer 
$ mysql -u kredo -p"password"

# nginx container
$ make web
```

### check browswer
```
web server:     http://localhost:8080/
php my admin:   http://localhost:8888/
```

### usage
```
# build container
$ make up

# check container
$ make ps

# stop container
$ make stop

# remove container
$ make down

# remove all of container stuff
# make destroy

# log for laravel
$ make logs
```


### FYI
#### if you want to use a specific laravel version, just replace a step1 command on [create laravel project and set up](https://github.com/hellomyzn/docker-laravel#crete-laravel-project-and-set-up)
```
# laravel 6
$ make create-project6

# laravel 7
$ make create-project6

# laravel 8
$ make create-project6
```# docker-laravel_archived
