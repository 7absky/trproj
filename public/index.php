<?php
require '../src/Tree/Autoloader.php';

$data = new \Tree\TreeData();
$builder = new \Tree\TreeStructure();
$nodes = $data->getAllNodes();
$category = $data->makeCategoryArray($nodes);
$tree = $builder->buildTreeView(0,$category);
$template = new \Tree\Template("../views/base.phtml");
$template->render("../views/index/index.phtml",['tree' => $tree]);

?>

