<?php
require '../src/Tree/Autoloader.php';

    if (!isset($_GET['id']) || empty ($_GET['id'])) {
        echo "Nie podałeś żadnego ID.";
        exit;
    }

    $data = new \Tree\TreeData();
    $node = $data->getNode($_GET['id']);
    $nodeId = $_GET['id'];
    $allNodes = $data->getAllNodes();
    $categories = $data->buildCategory($allNodes);

    $treeStruct = $data->buildTreeView($nodeId,$categories);

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
