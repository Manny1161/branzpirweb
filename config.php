<?php

	//DEFINE CREDENTIALS
	define("DB_HOST", 'localhost');
	define("DB_USERNAME", 'root');
	define("DB_PASSWORD", '');
	define("DB_DATABASE", 'branzpir');

	//DEFINE GLOBAL VARIABLES
	define("MAX_LOGIN_ATTEMPTS_PER_HOUR", 5);
	define("MAX_EMAIL_VERIFICATION_REQUESTS_PER_DAY", 3);
	define("MAX_PASSWORD_RESET_REQUESTS_PER_DAY", 3);
	define("CSRF_TOKEN_SECRET", 'affgff4f9anms8a0a');

	session_start();

	
?>