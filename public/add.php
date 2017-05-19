<?php
require '../src/Tree/Autoloader.php';

if (isset($_POST) && sizeof($_POST) > 0) {
	$data = new \Tree\TreeData();
	$data->add($_POST);
	header("Location: /ideotree/public");
	exit;
}

$template = new \Tree\Template("../views/base.phtml");
$template->render("../views/index/add.phtml");
?>
