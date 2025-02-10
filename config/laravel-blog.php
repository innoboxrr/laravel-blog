<?php

return [

	'lambda_token' => env('LARAVEL_BLOG_LAMBDA_TOKEN', 'lambda_token'),

	'lambda_endpoint' => env('LARAVEL_BLOG_LAMBDA_ENDPOINT', 'lambda_endpoint'),

	'ffmpeg' => env('FFMPEG_PATH', 'ffmpeg'),

	'ffprobe' => env('FFPROBE_PATH', 'ffprobe'),

	'database' => [
		'connection' => 'mysql',
	],

	'author_class' => 'App\Models\User',

	'bloggable' => [
		'create' => true,
	],

	'image_crop' => [
		'original' => [
			'width' => 1920,
			'height' => 1080,
		],
		'thumbnail' => [
			'width' => 300,
			'height' => 300,
		],
		'medium' => [
			'width' => 600,
			'height' => 600,
		],
		'large' => [
			'width' => 1200,
			'height' => 1200,
		],
	],

	'permissions' => [
		'blog-category-except-abilities' => [],
		'blog-except-abilities' => [],
		'blog-post-except-abilities' => [],
		'blog-subscriber-except-abilities' => [],
		'blog-tag-except-abilities' => [],
	],

	'search-options' => [
		'filtersPath' => 'vendor' . DIRECTORY_SEPARATOR . 'innoboxrr' . DIRECTORY_SEPARATOR . 'laravel-blog' . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'Models' . DIRECTORY_SEPARATOR . 'Filters',
		'filtersNamespace' => 'Innoboxrr\LaravelBlog\Models\Filters',
	],

	'user_class' => 'App\Models\User',

	'excel_view' => 'laravel-blog::excel.',

	'notification_via' => ['mail', 'database'],

	'export_disk' => 's3',

	'file_disk' => 's3',

	'file_directory' => 'public/blogs', // Para S3 de AWS

	'assets_mime_types' => [
        'css'   => 'text/css',
        'js'    => 'application/javascript',
        'html'  => 'text/html',
        'htm'   => 'text/html',
        'png'   => 'image/png',
        'jpg'   => 'image/jpeg',
        'jpeg'  => 'image/jpeg',
        'gif'   => 'image/gif',
        'woff2' => 'font/woff2',
        'woff'  => 'font/woff',
        'ttf'   => 'font/ttf',
    ],

    'assets_cdn_enabled' => env('LARAVEL_BLOG_CDN_ENABLED', false),

    'assets_cdn_url' => env('LARAVEL_BLOG_CDN_URL', ''),
	
];