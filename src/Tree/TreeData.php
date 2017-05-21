<?php 
namespace Tree;
class TreeData {

	protected $connection;

	public function connect () {
	    $config = \Tree\Config::get('database');
		$this->connection = new \PDO("mysql:host=".$config['hostname'].";dbname=" .$config['dbname'], $config['username'], $config['password']);
	}

	public function __construct() {
		$this->connect();
	}

	public function e ($value) {
	    return htmlspecialchars($value,ENT_QUOTES,'UTF-8');
    }

	public function getAllNodes () {
		$query = $this->connection->prepare("SELECT * FROM menus ORDER BY label, parent");
		$query->execute();

		return $query;
	}

	public function getLabels () {
	    $query = $this->connection->prepare("SELECT id, label FROM menus ORDER BY label");
	    $query->execute();
	    return $query;
    }

	public function makeCategoryArray ($query) {
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


	public function add ($data) {
		$query = $this->connection->prepare(
			"INSERT INTO menus (
				label,
				parent
			) VALUES (
				:label,
				:parent
			)"
		);

		$data = [
			':label' => $this->e($data['label']),
			':parent' => $this->e($data['parent'])
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
					parent = :parent
				WHERE
					id = :id"
		);

		$data = [
			':id' => $data['id'],
			':label' => $data['label'],
			':parent' => $data['parent']
		];

		return $query->execute($data);
	}
}
