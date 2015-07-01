### Converters

Converters convert legacy database records to Laravel models. Execute them by running:
    
    php artisan migrate:refresh
    php artisan convert:all

which runs all conversions found at ```app/Console/Commands```. You can list all the available conversions by running:

    php artisan list convert

When running the converter separately its recommended you first run:

    php artisan migrate:terms

Note that by default, only the small sample of legacy database is converted.