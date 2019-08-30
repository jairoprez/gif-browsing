# Laravel Rest API Skeleton

A standardized, organized, object-oriented foundation for building high-quality Rest APIs.

## Usage

1. Clone this repository
1. CD into the project root
1. Install Composer Dependencies using the command `composer install`
1. Copy `.env.example` to `.env` and fill in the details
1. Generate an app encryption key using the command `php artisan key:generate`
1. In the `.env` file, add database information to allow Laravel to connect to the database
1. Migrate the database using the command `php artisan migrate`
1. Next, you should run the `php artisan passport:install` command to create the encryption keys needed to generate secure access tokens