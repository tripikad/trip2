<?php

	return [

	    'header' => [
	       'news' => [
	            'route' => '/content/news'
	        ],
	       'flights' => [
	            'route' => '/content/flight'
	        ],
	        'travelmates' => [
	            'route' => '/content/travelmate'
	        ],
	        'forum' => [
	            'route' => '/content/forum'
	        ],
	        'photos' => [
	            'route' => '/content/photo'
	        ],
	        'blogs' => [
	            'route' => '/content/blog'
	        ],
	        'offers' => [
	            'route' => 'http://vana.trip.ee/reisipakkumised',
	            'external' => true
	        ],
	    ],

	    'footer' => [
	    	'trip_ee' => [
	            'route' => '/content/static/1534',
	        ],
	        'contact' => [
	            'route' => '/content/static/972',
	        ],
	        'eula' => [
	            'route' => '/content/static/25151',
	        ],
	        'advertising' => [
	            'route' => '/content/static/22125',
	        ],
	        'facebook' => [
	            'route' => 'https://facebook.com/tripeeee',
	            'external' => true
	        ],
	        'twitter' => [
	            'route' => 'https://twitter.com/trip_ee',
	            'external' => true
	        ],   	      
	    ],  

	    'news' => [
	    	'news' => [
	            'route' => '/content/news',
	        ],
	        'shortnews' => [
	            'route' => '/content/shortnews',
	        ],      
	    ], 

	    'forum' => [
	    	'forum' => [
	            'route' => '/content/forum',
	        ],
	        'expat' => [
	            'route' => '/content/expat',
	        ],
	        'buysell' => [
	            'route' => '/content/buysell',
	        ],  	      
	    ], 

	    'admin' => [
	    	'internal' => [
	            'route' => '/content/internal',
	        ],
	        'image' => [
	            'route' => '/admin/image',
	        ],
	        'unpublished' => [
	            'route' => '/admin/content/unpublished',
	        ],    	      
	    ], 

	];