# Run generating command

To make a Blade component, run

```sh
php artisan make:component MyComponent
```

and follow the directions.

To make a Vue component run

```sh
php artisan make:component MyComponent --vue
```

# The result

The following component files are created by the generator:

```
/resources/views/components/MyComponent.blade.php
/resources/views/components/MyComponent.vue // --vue
/resources/views/components/MyComponent.css
```

By default, the component accepts a `$title` parameter so you can test your component right away in your controller code:

```
<?php

namespace App\Http\Controllers;

class MyController extends Controller
{
    public function index() {
        return component('MyComponent')->with('title','Hello World')
    }
}
```

<mark>Tip</mark> When you generated a Vue component, run `npm run dev` to compile the Vue file to work on the frontend.
