<?php

return array(
	
	'fetch' => PDO::FETCH_CLASS,
	
	'default' => 'mysql',
	
	'connections' => array(
		
		'mysql' => array(
			
			'driver'    => 'mysql',
			'host'      => '192.168.1.99',
			'database'  => 'dev_rpc',
			'username'  => 'dev',
			'password'  => 'dev123456',
			'charset'   => 'utf8',
			'collation' => 'utf8_unicode_ci',
			'prefix'    => 'lv4_',
		),
		
	),
	
	'migrations' => 'migrations',
);