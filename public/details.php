<?php
require '../src/Tree/Autoloader.php';
require_once '../src/Tree/Config.php';
\Tree\Config::setDirectory('../config');

$config = \Tree\Config::get('autoload');
require_once  $config['class_path'] . '/Tree/Autoloader.php';

if (!isset($_GET['id']) || empty ($_GET['id'])) {
    echo "Nie podałeś żadnego ID.";
    exit;
}

$data = new \Tree\TreeData();
$builder = new \Tree\TreeStructure();
$node = $data->getNode($_GET['id']);
$nodeId = $_GET['id'];
$allNodes = $data->getAllNodes();
$categories = $data->makeCategoryArray($allNodes);

$treeStruct = $builder->showChildren($nodeId,$categories);

if ($node === false) {
    echo "Nie znaleziono węzła o podanym ID.";
    exit;
}

$template = new \Tree\Template("../views/base.phtml");
$template->render("../views/index/details.phtml", [
    'nodeId' =>$nodeId,
    'node' => $node,
    'tree' => $treeStruct
]);
