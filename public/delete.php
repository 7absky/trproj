<?php 
require '../src/Tree/Autoloader.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
	echo "You did not pass an ID.";
	exit;
} 

$data = new \Tree\TreeData();
$node = $data->getNode($_GET['id']);

if ($node === false) {
	echo "Topic not found.";
	exit;
}

if ($data->delete($_GET['id'])) {
	header ("Location: /treeproj/public");
	exit;
} else {
	echo "An error occurred.";

}