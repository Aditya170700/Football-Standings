## Requirements

-   PHP Version ^8.0.2
-   Laravel Version ^9.19
-   Composer Version 2.2.5

## Installation

1. Install dependencies `composer install`
2. Create new database
3. Setup environtment variables in `.env` files
4. Make file `.env` in root project
5. Copy content `.env.example` to `.env`
6. Configure DB connection in `.env` files
   `DB_CONNECTION=mysql`
   `DB_HOST='change db host'`
   `DB_PORT='change db port'`
   `DB_DATABASE='change db name'`
   `DB_USERNAME='change db username'`
   `DB_PASSWORD='change db password'`

7. Run `php artisan key:generate` to generate app key

8. Run migration and seeder In console
   `php artisan migrate --seed`

9. Run server In console
   `php artisan serve`

10. Login Credentials
    email `test@example.com`
    password `password`

![List Team](https://github.com/Aditya170700/Football-Standings/blob/main/public/team.png?raw=true)

![List Game](https://github.com/Aditya170700/Football-Standings/blob/main/public/game.png?raw=true)

![Add Game (Multiple)](https://github.com/Aditya170700/Football-Standings/blob/main/public/add-game.png?raw=true)

![Standings](https://github.com/Aditya170700/Football-Standings/blob/main/public/standings.png?raw=true)
