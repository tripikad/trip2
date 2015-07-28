<?php

return [


    'types' => [

        'news' => [
    
            'with' => ['destinations', 'topics'],
            'latest' => 'created_at',
            'paginate' => '24',
            'front' => true,
            'frontpaginate' => 3,
            'rules' => ['title' => 'required', 'url' => 'url', 'file' => 'image'],
            'fields' => [
                'file' => [
                    'type' => 'file',
                ],
                'title' => [
                    'type' => 'text',
                    'title' => 'Title',
                ],
                'body' => [
                    'type' => 'textarea',
                    'title' => 'Body',
                ],
                'url' => [
                    'type' => 'url',
                    'title' => 'URL',
                ],
                'submit' => [
                    'type' => 'submit',
                    'title' => 'Add',
                ]
            ]
        ],

        'flight' => [
    
            'title' => 'Flights',
            'with' => ['destinations', 'carriers'],
            'latest' => 'created_at',
            'paginate' => '24',
            'front' => true,
            'frontpaginate' => 4,
            'create' => [
                'title' => 'Add flight offer'
            ],
            'edit' => [
                'title' => 'Edit flight offer'
            ],
            'rules' => ['title' => 'required', 'url' => 'url'],
            'fields' => [
                'title' => [
                    'type' => 'text',
                    'title' => 'Title',
                ],
                'body' => [
                    'type' => 'textarea',
                    'title' => 'Body',
                ],
                'url' => [
                    'type' => 'url',
                    'title' => 'URL',
                ],
                'submit' => [
                    'type' => 'submit',
                    'title' => 'Add',
                ]
            ],
        ],

        'travelmate' => [
    
            'title' => 'Travelmates',
            'with' => ['user', 'destinations', 'topics'],
            'latest' => 'created_at',
            'paginate' => 24,
            'front' => true,
            'frontpaginate' => 4,
            'create' => [
                'title' => 'Add travelmate ad',
            ],
            'edit' => [
                'title' => 'Edit travelmate ad',
            ],              
            'rules' => ['title' => 'required', 'body' => 'required'],
            'fields' => [
                'title' => [
                    'type' => 'text',
                    'title' => 'Title',
                ],
                'body' => [
                    'type' => 'textarea',
                    'title' => 'Body',
                ],
                'submit' => [
                    'type' => 'submit',
                    'title' => 'Add',
                ]
            ],
        ],

        'forum' => [
    
            'title' => 'Forum',
            'with' => ['user', 'comments', 'flags', 'destinations', 'topics'],
            'latest' => 'updated_at',
            'paginate' => 25,
//            'front' => true,
            'frontpaginate' => 6,
            'create' => [
                'title' => 'Add forum post'
            ],
            'edit' => [
                'title' => 'Edit forum post'
            ],
            'rules' => ['title' => 'required', 'body' => 'required'],
            'fields' => [
                'title' => [
                    'type' => 'text',
                    'title' => 'Title',
                ],
                'body' => [
                    'type' => 'textarea',
                    'title' => 'Body',
                ],
                'submit' => [
                    'type' => 'submit',
                    'title' => 'Add',
                ]
            ],
        ],

        'photo' => [
        
            'title' => 'Photos',
            'with' => ['user', 'destinations'],
            'latest' => 'created_at',
            'paginate' => '24',
            'front' => true,
            'frontpaginate' => 3,
            'create' => [
                'title' => 'Add photo'
            ],
            'edit' => [
                'title' => 'Edit photo'
            ],
            'rules' => ['title' => 'required', 'file' => 'required|image'],
            'fields' => [
                'file' => [
                    'type' => 'file',
                ],
                'title' => [
                    'type' => 'textarea',
                    'title' => 'Description',
                    'rows' => 2
                ],
                'submit' => [
                    'type' => 'submit',
                    'title' => 'Add',
                ]
            ],
        ],

        'blog' => [
    
            'title' => 'Blogs',
            'with' => ['user', 'comments', 'destinations', 'topics'],
            'latest' => 'created_at',
            'paginate' => 25,
//            'front' => true,
            'frontpaginate' => 4,
            'create' => [
                'title' => 'Add blog post'
            ],
            'edit' => [
                'title' => 'Edit blog post'
            ],
            'rules' => ['title' => 'required', 'url' => 'url'],
            'fields' => [
                'title' => [
                    'type' => 'text',
                    'title' => 'Offer description',
                ],
                'body' => [
                    'type' => 'textarea',
                    'title' => 'Details',
                ],
                'url' => [
                    'type' => 'url',
                    'title' => 'URL',
                ],
                'submit' => [
                    'type' => 'submit',
                    'title' => 'Add',
                ]
            ],
        ],

        'offer' => [
        
            'title' => 'Offers',
            'with' => ['user', 'destinations'],
            'latest' => 'created_at',
            'paginate' => '24',
            'front' => true,
            'frontpaginate' => 4,
            'create' => [
                'title' => 'Add offer'
            ],
            'edit' => [
                'title' => 'Edit offer'
            ],
            'rules' => ['title' => 'required', 'url' => 'url'],
            'fields' => [
                'file' => [
                    'type' => 'file',
                ],
                'title' => [
                    'type' => 'textarea',
                    'title' => 'Offer description',
                    'rows' => 2
                ],
                'body' => [
                    'type' => 'textarea',
                    'title' => 'Details',
                ],
                'url' => [
                    'type' => 'url',
                    'title' => 'URL',
                ],
                'submit' => [
                    'type' => 'submit',
                    'title' => 'Add',
                ]
            ],
        ],

        'internal' => [
        
            'title' => '...',
            'with' => ['user', 'destinations', 'topics'],
            'latest' => 'created_at',
            'paginate' => 25,
            'create' => [
                'title' => 'Add post'
            ],
            'edit' => [
                'title' => 'Edit post'
            ],
            'rules' => ['title' => 'required', 'body' => 'required'],
            'fields' => [
                'title' => [
                    'type' => 'text',
                    'title' => 'Title',
                ],
                'body' => [
                    'type' => 'textarea',
                    'title' => 'Body',
                ],
                'submit' => [
                    'type' => 'submit',
                    'title' => 'Add',
                ]
            ],
        ],
    ],

    'allowed' => '(forum|blog|travelmate|news|flight|photo|offer|internal)'

];