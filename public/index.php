<?php

require_once implode(DIRECTORY_SEPARATOR, ['..', 'config', 'setup.php']);
require_once implode(DIRECTORY_SEPARATOR, [ROOT, 'vendor', 'autoload.php']);

session_start();

$requestUrl = filter_input(INPUT_SERVER, "REQUEST_URI");
$requestMethod = filter_input(INPUT_SERVER, "REQUEST_METHOD");

$router = new AltoRouter();

require_once implode(DIRECTORY_SEPARATOR, [ROOT, 'config', 'routes.php']);

$match = $router->match($requestUrl, $requestMethod);

if (is_array($match) && is_callable($match['target'])) {
    call_user_func_array($match['target'], $match['params']);
} elseif (is_bool($match) && !$match) {
    header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
    echo "<h1>404 Not Found : No route match for requested URL \"$requestUrl\" with \"$requestMethod\" method</h1>";
}
