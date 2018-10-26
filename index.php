<?php

spl_autoload_register(function ($className) {
    include $className . '.php';
});

$input = file_get_contents('input.txt');

if (!is_numeric($argv[1]) || !is_numeric($argv[2])) {
    echo 'Wrong coordinates!';
    die;
}

try {
    $parser = new \Parser($input);
    $parser->parse()->draw($argv[1], $argv[2]);
} catch (Exception $exception) {
    echo sprintf('Exception: %s %s %i', $exception->getMessage(),  $exception->getFile(), $exception->getLine());
}
