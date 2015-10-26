## Installation

### Automatic setup

It's recommended to use our Vagrant machine for development. See https://github.com/tripikad/trip2_vagrant/blob/master/README.md

### Manual setup

#### Installing

You need to have LEMP stack, Composer and NodeJS installed. 

    git clone https://github.com/tripikad/trip2.git
    cd trip2
    composer install --prefer-source --no-interaction
    npm install
    gulp
    sudo chown -R www-data:www-data /var/www
    sudo chmod -R o+w bootstrap/cache/
    sudo chmod -R o+w storage/
    sudo chmod -R o+w public/images/
    cp .env.example .env
    php artisan key:generate

Note: If you have problems with ```npm install```, try to run ```npm install --no-bin-links```.

#### Configuration

Then  add following parameters to ```/.env```:

    DB_HOST1=127.0.0.1
    DB_DATABASE1=trip
    DB_USERNAME1=root
    DB_PASSWORD1=secret

    DB_HOST2=127.0.0.1
    DB_DATABASE2=trip2
    DB_USERNAME2=root
    DB_PASSWORD2=secret

    DB_CONNECTION=trip2

Now you should be able to access the web app and also run console commands.

#### Set up databases

    mysqladmin -uroot -psecret create trip
    mysqladmin -uroot -psecret create trip2

and then dump your database dump to the legacy database

    mysql -uroot -psecret trip < your_dumpfile.sql

### Converters

Converters convert legacy database records to Laravel models. Execute them by running:
    
    php artisan migrate:refresh
    php artisan convert:all
    
which runs all conversions found at ```app/Console/Commands```. You can list all the available conversions by running:

    php artisan list convert

There are more parameters you can set up for conversion. Refer this: https://github.com/tripikad/trip2/blob/master/app/Console/Commands/ConvertBase.php#L58

### Tests

First, set the following in ```/.env``` file:

    MAIL_DRIVER=log

Then run

    ./vendor/bin/phpunit

To run particular test, run

    ./vendor/bin/phpunit tests/YourTestName.php

### Frontend architecture

See ```/styleguide``` for visual reference of the frontend setup, below is the technical overview.

#### HTML / Blade templates

Blade templates are organized into following structure:

    /resources/views/page
    /resources/views/layout
    /resources/views/component

The entrypoing to the templates are pages. They are called from controllers using ```view('page.pagename')```, they compose the HTML by getting a right layout (using ```@extend(layout.layoutname')```) and filling the page with components (using ```@include(component.componentname)```, passing on data from the controller.

##### Components

Here is a sample component HTML, we use BEM convention for class names and ```c-``` prefix for components.

```mustache

    {{-- /resources/views/component/sample.blade.php --}}

    <div class="c-sample">
        <h3 class="c-sample__title">{{ $title }}
        <p class="c-sample__title">{{ $text }}
    </div>

```
