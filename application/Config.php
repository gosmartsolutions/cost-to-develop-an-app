<?php

//Timezone
date_default_timezone_set('UTC');

//SET DEFAULTS IF NOTHING IS PASSED IN QUERYSTRING
define('DEFAULT_SERVER', 'sendgrid');
define('DEFAULT_SEND_LIMIT', 1);

//WEBSITE
define('WEBSITE_NAME', "Cost To Develop An App");
define('WEBSITE_DOMAIN', "http://www.costtodevelopanapp.com");
define('DOMAIN_NAME', "costtodevelopanapp.com");

//It can be the same as domain (if script is placed on website's root folder) 
//or it can contain path that include subfolders, if script is located in some subfolder and not in root folder
define('SCRIPT_URL', "http://www.costtodevelopanapp.com/");

//DATABASE CONFIGURATION
define('DB_HOST', 'host');
define('DB_TYPE', 'mysql');
define('DB_USER', 'user');
define('DB_PASS', 'pass');
define('DB_NAME', 'db name');

//ADMIN EMAILS AND OTHER STUFF
define('ADMIN_EMAIL', 'your email');
define('ADMIN_EMAIL_NAME', 'your name');

//API Keys
define('MAILGUN_KEY', 'your mailgun api key');
define('SENDGRID_KEY', 'your sendgrid api key');


