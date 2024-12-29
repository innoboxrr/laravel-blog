<?php

return [

	'database' => [
		'connection' => 'mysql',
	],

	'author_class' => 'App\Models\User',

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

	'user_class' => 'App\Models\User',

	'excel_view' => 'innoboxrrlaravelblog::excel.',

	'notification_via' => ['mail', 'database'],

	'export_disk' => 's3',
	
];