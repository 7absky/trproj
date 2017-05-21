<?php 
require '../src/Tree/Autoloader.php';
require_once '../src/Tree/Config.php';
\Tree\Config::setDirectory('../config');

$config = \Tree\Config::get('autoload');
require_once  $config['class_path'] . '/Tree/Autoloader.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
	echo "Musisz podać konkretne id";
	exit;
} 

$data = new \Tree\TreeData();
$node = $data->getNode($_GET['id']);

if ($node === false) {
	echo "Nie znalazłem takiego węzła";
	exit;
}

if ($data->delete($_GET['id'])) {
	header ("Location: /ideotree/public");
	exit;
} else {
	echo "Wystąpił błąd";

}