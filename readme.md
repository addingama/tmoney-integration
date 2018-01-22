# TMoney Integration Sample Project

## Requirements

- PHP >= 5.6.4
- OpenSSL PHP Extension
- PDO PHP Extension
- Mbstring PHP Extension
- XML PHP Extension
- mySql
- GIT
- Node.js
- NPM

## Source code installation

First, make sure you already install `GIT` and setup your `ssh key`. You can download GIT installer from [this link](https://git-scm.com). After that, you need to setup your ssh key from terminal. Open terminal then run this command

```
ssh-keygen
```

Fill all the data, for the password, it's up to you to fill it or leave it blank.


Then clone the source code using `GIT` so you can access move to other branches to see all the code changes for each features. 

Open your terminal and navigate to your project directory and run this command

```
git clone https://github.com/dashracer/tmoney-integration.git sample-project
```

Those command will create a new directory named `sample-project`, then you need to navigate to that folder in terminal using ```
cd sample-project
```

After that, you need to update the dependencies using command
```
composer install
```

Create a database using PhpMyAdmin or terminal with name `tmoney-integration-sample` and leave it with no table.

Open the source code project on IDE like sublime or others then copy `.env.example` to `.env` or you can rename `.env.example` to '.env`, then update the value

```
APP_NAME="TMoney Sample Project"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_LOG_LEVEL=debug
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=tmoney-integration-sample
DB_USERNAME=CHANGE_THIS_WITH_YOUR_DB_USERNAME
DB_PASSWORD=CHANGE_THIS_WITH_YOUR_DB_PASSWORD
```

Then update your `APP_KEY` by running this command on terminal
```
php artisan key:generate
```

After that, you need to execute the migration script by running this command
```
php artisan migrate
```

If you encounter any error on this step, make sure you delete all the tables first before executing the migration again.
This is other solution for your problem that you may encounter:

- [SQL error when migrating tables](https://github.com/laravel/framework/issues/17508)

After all installed, now you can test it by running the laravel server by this command
```
php artisan serve
```

## Notes

- Default user type for TMoney is Basic Service, this user can have balance up to 1.000.000 and cannot do transfer balance.
- You need to contact TMoney Representative or Pak Putra if you want to upgrade to Full Service and topup the balance so you can try some payment or purchase.

