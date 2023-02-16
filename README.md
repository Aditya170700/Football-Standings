## Requirements

PHP Version ^8.0.2
Laravel Version ^9.19
Composer Version 2.2.5

## Installation

Install dependencies `composer install`

Create new database
Setup environtment variables in `.env` files
Make file `.env` in root project
Copy content `.env.example` to `.env`
Configure DB connection in `.env` files

```
DB_CONNECTION=mysql
DB_HOST='change db host'
DB_PORT='change db port'
DB_DATABASE='change db name'
DB_USERNAME='change db username'
DB_PASSWORD='change db password'
```

Run `php artisan key:generate` to generate app key

Run migration and seeder
In console
`php artisan migrate --seed`

Run server
In console
`php artisan serve`

Login Credentials
email `test@example.com`
password `password`

![List Team](https://github.com/Aditya170700/Football-Standings/blob/main/public/team.png?raw=true)

![List Game](https://github.com/Aditya170700/Football-Standings/blob/main/public/game.png?raw=true)

![Add Game (Multiple)](https://github.com/Aditya170700/Football-Standings/blob/main/public/add-game.png?raw=true)

![Standings](https://github.com/Aditya170700/Football-Standings/blob/main/public/standings.png?raw=true)
