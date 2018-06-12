<?php

define('APP_PATH', dirname(dirname(__FILE__)));
define('APP_URL', 'http://localhost/sarahah/');//link of the website or application. must be written correctly or you will face css & js files errors
define('SITENAME', 'SECRETS'); //NAME OF THE WEBSITE
define('UPLOADS_DIR', APP_PATH . '/../public/uploads');
define('ADMIN_EMAIL', 'sniffabyte@gmail.com'); //the admin email to Contact with if error messages appeared.

//database
define('DB_HOST', '');//your database host
define('DB_NAME', '');//create a database and put it's name here
define('DB_USER', '');//database user who has previlliges to select, update and delete
define('DB_PASS', '');//password of the user

/*
your mailer informations:
you must edit it with a real data or you will face problems in sending emails
*/
//mailer informations
define('SMTP_HOST', 'smtp1.example.com;smtp2.example.com'); //smtp host
define('SMTP_USER', 'user@example.com'); //smtp username
define('SMTP_PASS', 'secret'); //smtp password
define('SMTP_PORT', 587); //smtp port
define('SMTP_FROM_NAME', SITENAME); //smtp from name
define('SMTP_FROM_EMAIL', 'from@example.com'); //smtp from email
