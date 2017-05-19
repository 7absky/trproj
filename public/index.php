<?php
require '../src/Tree/Autoloader.php';

$data = new \Tree\TreeData();
$nodes = $data->getAllNodes();
$category = $data->buildCategory($nodes);
$tree = $data->buildTreeView(0,$category);
$template = new \Tree\Template("../views/base.phtml");
$template->render("../views/index/index.phtml",['tree' => $tree]);

?>

