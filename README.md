# Testing Laravel 8 + Sqlite using imgbb

A simple laravel CRUD using a sqlite as a db and a service ImgBB to upload some images.
# Demo
**https://laravel8-posts.herokuapp.com/**

# Requirements
* [PHP >= 7](https://www.php.net/downloads.php) 
* [Composer >= 2](https://getcomposer.org/download/)

# Setup
```
git clone https://github.com/stdioh321/laravel.git
cd laravel
composer install
php artisan migrate:fresh --seed --env=example
```
# Run
```
php artisan serve --env=example
```

Open your browser at:

### **http://localhost:8000**

# Run with Docker
```
docker run -p8080:8080 -it diaslinoh/laravel-posts:latest

```
![Terminal](https://i.imgur.com/DphzeCV.png)

Open your browser at:

**http://localhost:8080**

![Browser1](https://i.imgur.com/Oyyy41J.png)


![Browser2](https://i.imgur.com/R3ZFCyD.png)

# References

* [Laravel](https://laravel.com/docs/8.x/)
* [ImgBB](https://imgbb.com/)
