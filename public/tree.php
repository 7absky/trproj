<?php
require_once '../src/Tree/Config.php';
\Tree\Config::setDirectory('../config');

$config = \Tree\Config::get('autoload');
require_once  $config['class_path'] . '/Tree/Autoloader.php';

if (!isset($_GET['param']) || !isset($_GET['sort'])) {
    echo "Musisz podać warunki sortowania.";
    echo $_GET['param'];
    echo $_GET['sort'];
    exit;
}

if (isset($_GET['param']) && isset($_GET['sort'])) {
    $data = new \Tree\TreeData();
    $builder = new \Tree\TreeStructure();
    if ($nodes = $data->getSortedNodes($_GET['param'],$_GET['sort'])) {
        // fetching all nodes from database
        $category = $data->makeCategoryArray($nodes); // prepare category array
        $tree = $builder->buildTreeView(0,$category);
        $template = new \Tree\Template("../views/base.phtml");
        $template->render("../views/index/index.phtml",[
            'tree' => $tree,
        ]);
    } else {
        echo "Wystąpił błąd";
        exit;
    }

}


