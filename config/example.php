<?php defined('SYSPATH') or die('No direct script access.');
return array(
	'mail_options' => array(
		'driver' => 'smtp',
		'host' => 'host',
		'port' => 25,
		'auth' => true,
		'username' => 'youruser',
		'password' => 'yourpassword',
		'debug' => false,

		'sender_email' => 'test@test.com',
		'sender_name' => 'Emailq'

	),
);