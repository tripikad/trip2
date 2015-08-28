### Installation

You need to have [Composer](https://github.com/kristjanjansen/trip2_vagrant/blob/master/provision.sh#L46) and [NodeJS and Gulp](https://github.com/kristjanjansen/trip2_vagrant/blob/master/provision.sh#L105) installed. Then:

    git clone https://github.com/kristjanjansen/trip2.git
    cd trip2
    composer install
    npm install
    gulp
    sudo chown -R www-data:www-data /var/www
    sudo chmod -R o+w bootstrap/cache/
    sudo chmod -R o+w storage/
    sudo chmod -R o+w public/images/
    cp .env.example .env
    php artisan key:generate

Note: If you have problems with ```npm install```, try to run ```npm install --no-bin-links```.

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

### Set up databases

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

When running the converter separately its recommended you first run:

    php artisan migrate:terms

Note that by default, only the small sample of legacy database is converted. To overwrite this add following parameter to ```.env```:

    CONVERT_TAKE=how_many_items

Note that maximum number of items in databases is around 110000.

If you also want to convert images, add following to ```.env```:
    
    CONVERT_FILES=true
