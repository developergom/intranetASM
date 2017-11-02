<?php

return array(

	/*
	|--------------------------------------------------------------------------
	| Enable Backup
	|--------------------------------------------------------------------------
	|
	| Enable database backup.
	|
	*/
	'enabled' => true,

	/*
	|--------------------------------------------------------------------------
	| Path
	|--------------------------------------------------------------------------
	|
	| A database backup path, absolute path, or path relative from public
	| directory, a trailing slash is required.
	|
	*/
	'path' => storage_path('backup/'),

	/*
	|--------------------------------------------------------------------------
	| Filename
	|--------------------------------------------------------------------------
	|
	| A database export filename to use when exporting databases.
	|
	*/
	'filename' => 'igom-backup-' . date('Ymd'),

	/*
	|--------------------------------------------------------------------------
	| Enable Compression
	|--------------------------------------------------------------------------
	|
	| Enable backup compression using gzip. Requires gzencode/gzdecode.
	|
	*/
	'compress' => true,

	/*
	|--------------------------------------------------------------------------
	| Database Engine Processors
	|--------------------------------------------------------------------------
	|
	| Set the database engines processor location, trailing slash is required.
	|
	*/
	'processors' => array(
		'mysql' => array(
			'export' => env('DB_PROCESSOR_DIR', '/usr/bin/'),
			'restore' => env('DB_PROCESSOR_DIR', '/usr/bin/')
		),
		'pqsql' => array(
			'export' => env('DB_PROCESSOR_DIR', '/usr/bin/'),
			'restore' => env('DB_PROCESSOR_DIR', '/usr/bin/')
		),
		'sqlite' => array(
			'export' => env('DB_PROCESSOR_DIR', null),
			'restore' => env('DB_PROCESSOR_DIR', null)
		),
		'sqlsrv' => array(
			'export' => env('DB_PROCESSOR_DIR', '/usr/bin/'),
			'restore' => env('DB_PROCESSOR_DIR', '/usr/bin/')
		),
	),

);
