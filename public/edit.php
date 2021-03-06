<?php 
require '../src/Tree/Autoloader.php';
require_once '../src/Tree/Config.php';
\Tree\Config::setDirectory('../config');

$config = \Tree\Config::get('autoload');
require_once  $config['class_path'] . '/Tree/Autoloader.php';

if (isset($_POST['id']) && !empty($_POST['id'])) {
    $data = new \Tree\TreeData();
    if ($data->update($_POST)) {
        header("Location: /ideotree/public");
        exit;
    } else {
        echo "Wystąpił błąd";
        exit;
    }
}


if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "Nie podałeś żadnego ID.";
    exit;
}


$data = new \Tree\TreeData();
$node = $data->getNode($_GET['id']);
$labels = $data->getLabels(); // labels for select field
if ($node === false) {
    echo "Nie znaleziono takiego węzła";
    exit;
}

$template = new \Tree\Template("../views/base.phtml");
$template->render("../views/index/edit.phtml", [
    'node'=>$node,
    'labels' => $labels
]);


