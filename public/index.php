<?php
require '../src/Tree/Autoloader.php';
require_once '../src/Tree/Config.php';
\Tree\Config::setDirectory('../config');

$config = \Tree\Config::get('autoload');
require_once  $config['class_path'] . '/Tree/Autoloader.php';


$data = new \Tree\TreeData();
$builder = new \Tree\TreeStructure();
$nodes = $data->getAllNodes();
$category = $data->makeCategoryArray($nodes);
$tree = $builder->buildTreeView(0,$category);
$template = new \Tree\Template("../views/base.phtml");
$template->render("../views/index/index.phtml",[
    'tree' => $tree,
    ]);

?>

