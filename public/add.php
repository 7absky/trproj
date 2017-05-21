<?php

require_once '../src/Tree/Config.php';
\Tree\Config::setDirectory('../config');

$config = \Tree\Config::get('autoload');
require_once  $config['class_path'] . '/Tree/Autoloader.php';

if (isset($_POST) && sizeof($_POST) > 0 && $_POST['label'] != null) {
	$data = new \Tree\TreeData();
	$data->add($_POST);
	header("Location: /ideotree/public");
	exit;
}


$labelsData = new \Tree\TreeData();
$labels = $labelsData->getLabels();
$template = new \Tree\Template("../views/base.phtml");
$template->render("../views/index/add.phtml",[
	'labels' => $labels
]);
?>
