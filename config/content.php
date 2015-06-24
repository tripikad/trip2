<?php

return [


    'types' => [

        'forum' => [
    
            'title' => 'Forum',
            'with' => ['user', 'comments', 'flags']
    
        ]
    
    ],

    'allowed' => '(forum|blog|misc)'

];