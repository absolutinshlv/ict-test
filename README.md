## Run application

To run application you will need Docker and WSL.

1. Clone git repository
2. Inside new directory terminal type ```./vendor/bin/sail up``` to build and run containers.
3. When containers are up in first time you need to migrate database and seed it. To do that **Open Docker container ict-test-laravel.test-1** and Exec ```php artisan migrate --seed```
4. Enjoy!
