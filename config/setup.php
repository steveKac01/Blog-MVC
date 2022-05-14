<?php

define('ROOT', realpath(__DIR__ . DIRECTORY_SEPARATOR . ".."));
define('VIEW', ROOT . DIRECTORY_SEPARATOR . 'view');
define('DATABASE_CONFIG_PATH', implode(DIRECTORY_SEPARATOR, [ROOT, 'config', 'database.ini']));
//Max items displayed per page.
define('MAX_ARTICLES_DISPLAYED',4);
define('MAX_COMMENTS_DISPLAYED',2);
