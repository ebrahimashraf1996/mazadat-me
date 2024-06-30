<?php

return [
	'mode'                  => 'utf-8',
	'format'                => 'A4',
	'author'                => '',
	'subject'               => '',
	'keywords'         		=> 'PDF, Laravel, Package, Peace', // Separate values with comma
	'creator'          		=> 'Laravel Pdf',
	'display_mode'     		=> 'fullpage',
	'tempDir'               => base_path('../temp/'),
	'pdf_a'                 => false,
	'pdf_a_auto'            => false,
	'icc_profile_path'      => '',
	'font_path' => base_path('public/assets/fonts/static/'),
	'font_data' => [
		'cairo' => [
			'R'  => 'Cairo-Bold.ttf',    // regular font
			'B'  => 'Cairo-Bold.ttf',       // optional: bold font
			'useOTL' => 0xFF,    // required for complicated langs like Persian, Arabic and Chinese
			'useKashida' => 100,  // required for complicated langs like Persian, Arabic and Chinese
		]
		// ...add as many as you want.
	]
];
