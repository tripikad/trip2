<?php

return [


    'types' => [

        'forum' => [
    
            'title' => 'Forum',
            'with' => ['user', 'comments', 'flags'],
            'latest' => 'updated_at',
            'paginate' => '25'
    
        ],

        'blog' => [
    
            'title' => 'Blogs',
            'with' => ['user', 'comments'],
            'latest' => 'created_at',
            'paginate' => '25'
    
        ]
    
    ],

    'allowed' => '(forum|blog)'

];