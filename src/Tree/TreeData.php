<?php 
namespace Tree;
class TreeData {

	protected $connection;

	public function connect () {
		$this->connection = new \PDO("mysql:host=localhost;dbname=ideo", "root","root");
	}

	public function __construct() {
		$this->connect();
	}

	public function getAllNodes () {
		$query = $this->connection->prepare("SELECT * FROM menus ORDER BY label, parent, sort");
		$query->execute();

		return $query;
	}

	public function buildCategory ($query) {
		$category = array(
			'categories' => array(),
			'parent_cats' => array()
		);

		while($row = $query->fetch(\PDO::FETCH_ASSOC)) {
			$category['categories'][$row['id']] = $row;

			$category['parent_cats'][$row['parent']][] = $row['id'];
		}

		return $category;
	}

	public function buildTreeView ($parent, $category) {
		$html = ""; 
		if (isset($category['parent_cats'][$parent])) {
			$html .= "<ul class='tree'>";
			foreach ($category['parent_cats'][$parent] as $cat_id) {
				if (!isset($category['parent_cats'][$cat_id])) {
					$html .= "<li><label>". $category['categories'][$cat_id]['label'] . "<a class='btn btn-xs btn-primary' href='edit.php?id=" .$category['categories'][$cat_id]['id']."'> Edit  </a> <a class='btn btn-xs btn-danger' href='delete.php?id=" .$category['categories'][$cat_id]['id']."'> Delete  </a></label> <input type='checkbox'/></li>";
				}
				if (isset($category['parent_cats'][$cat_id])) {
					$html .= "<li><label>". $category['categories'][$cat_id]['label'] . "<a class='btn btn-xs btn-primary' href='edit.php?id=" .$category['categories'][$cat_id]['id']."'> Edit  </a> <a class='btn btn-xs btn-danger' href='delete.php?id=" .$category['categories'][$cat_id]['id']."'> Delete  </a></label> <input type='checkbox'/>";
					$html .= $this->buildTreeView ($cat_id, $category);
					$html .= "</li>";
				}
			}
			$html .= "</ul>";
		}
		return $html;
	}

	public function add ($data) {
		$query = $this->connection->prepare(
			"INSERT INTO menus (
				label,
				parent,
				link
			) VALUES (
				:label,
				:parent,
				:link
			)"	
		);

		$data = [
			':label' => $data['label'],
			':parent' => $data['parent'],
			':link' => $data['link']
		];

		$query->execute($data);
	}

	public function delete ($id) {
		$query = $this->connection->prepare(
			"DELETE FROM menus
				WHERE
					id = :id"
		);

		$data = [
			':id' => $id,
		];

		return $query->execute($data);
	}

	public function getNode ($id) {
		$sql= "SELECT * FROM menus WHERE id = :id LIMIT 1";
		$query = $this->connection->prepare($sql);

		$values = [':id' => $id];
		$query->execute($values);

		return $query->fetch(\PDO::FETCH_ASSOC);
	}

	public function update($data) {
		$query = $this->connection->prepare(
			"UPDATE menus 
				SET
					label = :label,
					link = :link
				WHERE
					id = :id"
		);

		$data = [
			':id' => $data['id'],
			':label' => $data['label'],
			':link' => $data['link']
		];

		return $query->execute($data);
	}
}
