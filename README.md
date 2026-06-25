<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>



## Manual

1) First download the repo: https://github.com/navintanzim/HR/tree/polaris.

2) Be careful to use the polaris branch, the main and master are not valid. Its set as default but still be sure. git clone --branch polaris https://github.com/navintanzim/HRMVP.git

3) Create a database according to the .env file key DB_DATABASE.

4) Run the following commands:
--------------------------------

We assume you have both composer and npm installed. This project was built on Composer version: 2.8.9 and npm version:10.9.2. But it should still run on most contemporary versions.

composer update (just to be sure)
php artisan migrate 
php artisan db:seed
php artisan serve

Open a second terminal and run:

npm install      
npm run build  
npm run dev     

5) You should see a login option at http://localhost:8000/

You have two types of users: Employee and Admin. They are defined by the 'Roles' radio button. An employee can check in for daily attendance and apply for leave. An admin can approve/reject the leaves but can not apply himself or check in. But he has access to additional modules like Settings and Users. Settings defines app configurations like office time, default leave days etc. Users module handles new user creation. Only the admin can create new users. New users cant register themselves, so to make new users, you must login as an admin. To get his login credentials, check the DatabaseSeeder.php file.

The auto absent cron is scheduled at app/Console/Kernel.php. You can modify it there if needed. Or if you simply want to change the time limit for absent, do so at the Settings module as an admin. Generally, an employee will be made auto absent at 9:30.
  

