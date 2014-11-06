<?php
define('SS_ENVIRONMENT_TYPE', 'dev');
define('SS_DATABASE_SERVER', 'localhost');
define('SS_DATABASE_USERNAME', 'root');
define('SS_DATABASE_PASSWORD', '');
define('SS_DATABASE_CHOOSE_NAME', 2);

global $_FILE_TO_URL_MAPPING;
$_FILE_TO_URL_MAPPING['/gitlab-ci-runner.git/tmp/builds'] = 'http://localhost';
