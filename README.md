### Converters

Converters convert legacy database records to Laravel models. Run them by entering:

    php artisan convert:all

which runs all conversions found at ```app/Console/Commands```.

Note that by default, only the small sample of legacy database is converted. To adjust the limit, provide a ```--limit=``` parameter.