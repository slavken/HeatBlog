# HeatBlog

<p align="center"><img src="public/img/logolockup.png" width="400"></p>

## Start in 5 steps
1. `composer install`
2. Create .env using .env.example: `cp .env.example .env`
3. `php artisan key:generate`
4. `php artisan migrate --seed` (or `migrate:fresh`)
5. `php artisan storage:link`
