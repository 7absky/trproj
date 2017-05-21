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

	// very simple xss attack protection
	public function e ($value) {
	    return htmlspecialchars($value,ENT_QUOTES,'UTF-8');
    }

	public function getAllNodes () {
	    // select all rows from menus table
		$query = $this->connection->prepare("SELECT * FROM menus ORDER BY id, parent");
		$query->execute();

		return $query;
	}

    public function getSortedNodes ($param, $sort) {
        // select all rows from menus table
        $query = $this->connection->prepare("SELECT * FROM menus ORDER BY {$param} {$sort}");
        $data = [
            ':param' => $this->e($param),
            ':sort' => $this->e($sort)
        ];
        $query->execute($data);

        return $query;
    }

	public function getLabels () {
	    $query = $this->connection->prepare("SELECT id, label FROM menus ORDER BY label");
	    $query->execute();
	    return $query;
    }

	public function makeCategoryArray ($query) {
	    // create a multidimensional array which holds categories and parents ids
		$category = array(
			'categories' => array(),
			'parent_cats' => array()
		);

		// inserting data from database to category array
		while($row = $query->fetch(\PDO::FETCH_ASSOC)) {
		    // inserts current row's category id into an array
			$category['categories'][$row['id']] = $row;
            // parent_cats array contains list of categories which have children
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

	// fetch single node from database
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
			':id' => $this->e($data['id']),
			':label' => $this->e($data['label']),
			':parent' => $this->e($data['parent'])
		];

		return $query->execute($data);
	}
}
