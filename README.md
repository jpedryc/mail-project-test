# Mail project - TEST

### Set up

Besides the usual Laravel set up, I do recommend using `php artisan migrate --seed`. A default
user will be created with an assigned API token (for simplicity - plain-text available in DB).

### Tech stack

* Laravel
* Redis for queueing
* [HELO by beyondcode](https://github.com/beyondcode/helo-laravel) for email testing

### Testing

`php artisan test`
