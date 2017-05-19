<?php 
	require '../src/Tree/Autoloader.php';

	if (isset($_POST['id']) && !empty($_POST['id'])) {
		$data = new \Tree\TreeData();
		if ($data->update($_POST)) {
			header ("Location: /treeproj/public");
			exit;
		} else {
			echo "An error occurred";
			exit;
		}
	}

	if (!isset($_GET['id']) || empty($_GET['id'])) {
		echo "You did not pass in and ID.";
		exit;
	}
	$data = new \Tree\TreeData();
	$node = $data->getNode($_GET['id']);

	if ($node === false) {
		echo "Node not found!";
		exit;
	}

	$template = new \Tree\Template("../views/base.phtml");
	$template->render("../views/index/edit.phtml", ['node'=>$node]);

?>
