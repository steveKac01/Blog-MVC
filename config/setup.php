<?php

define('ROOT', realpath(__DIR__ . DIRECTORY_SEPARATOR . ".."));
define('VIEW', ROOT . DIRECTORY_SEPARATOR . 'view');
define('DATABASE_CONFIG_PATH', implode(DIRECTORY_SEPARATOR, [ROOT, 'config', 'database.ini']));
define('MAX_ARTICLE_DISPLAYED',3);
