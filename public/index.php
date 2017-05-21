<?php
require_once '../src/Tree/Config.php';
\Tree\Config::setDirectory('../config');

$config = \Tree\Config::get('autoload');
require_once  $config['class_path'] . '/Tree/Autoloader.php';


$data = new \Tree\TreeData();
$builder = new \Tree\TreeStructure();
$nodes = $data->getAllNodes(); // fetching all nodes from database
$category = $data->makeCategoryArray($nodes); // prepare category array
$tree = $builder->buildTreeView(0,$category);

$template = new \Tree\Template("../views/base.phtml");
$template->render("../views/index/index.phtml",[
    'tree' => $tree,
    ]);

?>

