<?php
return [
    'class_path' => realpath('../src')
];

$config = \Tree\Config::get('autoload');

$file = $config['class_path'] . '/' . str_replace("\\", "/", $className) . '.php';
?>