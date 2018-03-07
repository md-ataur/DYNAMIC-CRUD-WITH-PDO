<?php
class Database{
	private $host = "localhost";
	private $user = "root";
	private $pass = "";
	private $db   = "db_student";
	private $pdo;

	public function __construct(){
		if (!isset($this->pdo)) {
			try{
				$this->pdo = new PDO("mysql:host=".$this->host.";dbname=".$this->db,$this->user,$this->pass);
			}catch (PDOException $e) {
				echo $e->getMessage();
			}
		}
	}


// Select method

/*
	$sql   = "SELECT * FROM tableName WHERE id=':id' AND email=':email' ORDER BY id DESC LIMIT 5,2'";
	$query = $this->pdo->prepare($sql);
	$query->bindValue(':id', $id);
	$query->bindValue(':email', $email);
	$query->execute();
*/
	
	public function select($table, $data = array()){
		$sql  = 'SELECT ';
		$sql .= array_key_exists('select', $data)?$data['select']:'*';
		$sql .= ' FROM '.$table;
		if (array_key_exists('where', $data)) {
			$sql .= ' WHERE ';
			$i = 0;
			foreach ($data['where'] as $key => $value) {
				$add = ($i > 0)?' AND ':'';
				$sql .= "$add"."$key=:$key";
				$i ++;
			}
		}
		if (array_key_exists('order_by', $data)) {
			$sql .= ' ORDER BY '.$data['order_by'];
		}

		if (array_key_exists('start', $data) && array_key_exists('limit', $data)) {
			$sql .= ' LIMIT '.$data['start'].','.$data['limit'];
		}elseif (array_key_exists('limit', $data)) {
			$sql .= ' LIMIT '.$data['limit'];
		}

		$query = $this->pdo->prepare($sql);

		if (array_key_exists('where', $data)) {
			foreach ($data['where'] as $key => $value) {
				$query->bindValue(":$key", $value);
			}
		}
		$query->execute();

		if (array_key_exists('return_type', $data)) {
			switch ($data['return_type']) {
				case 'count':
					  $value = $query->rowCount();
					break;

				case 'single':
					  $value = $query->fetch(PDO::FETCH_ASSOC);
					break;	
				
				default:
					$value = '';
					break;
			}
		}else{
			if ($query->rowCount() > 0) {
				$value = $query->fetchAll();
			}
		}
		return !empty($value)?$value:false;
	}



// Insert method

/*
	$sql = "INSERT INTO tableName (name, email) VALUES (:name, :email)";
	$query = $this->pdo->prepare($sql);
	$query->bindValue(':name', $name);
	$query->bindValue(':email', $email);
	$query->execute();
*/
	
	public function insert($table, $data){	
		if (!empty($data) && is_array($data)) {
			$keys = '';
			$values = '';

			$keys = implode(',', array_keys($data));
			$values = ":".implode(', :', array_keys($data));
			$sql = "INSERT INTO ".$table." (".$keys.") VALUES (".$values.")" ;
			$query = $this->pdo->prepare($sql);

			foreach ($data as $key => $value) {
				$query->bindValue(":$key", $value);
			}

			$insertData = $query->execute();
			if ($insertData) {
				$lastid = $this->pdo->lastInsertId();
				return $lastid;
			} else {
				return false;
			}
			
		}
	}

// Update method

/*
	$sql = "UPDATE tableName SET name=:name, email=:email, WHERE id=:id";
	$query = $this->pdo->prepare($sql);
	$query->bindValue(':name', $name);
	$query->bindValue(':email', $email);
	$query->bindValue(':id', $id);
	$query->execute();
*/
	public function update($table, $data, $cond){
		if (!empty($data) && is_array($data)) {
			$keyvalue  = '';
			$whereCond = '';
			
			$i = 0;
			foreach ($data as $key => $val) {
				$add = ($i > 0)?' , ':'';
				$keyvalue .= "$add"."$key=:$key";
				$i ++;
			}

			//echo $keyvalue;
			//die();

			if (!empty($cond) && is_array($cond)) {
				$whereCond .= " WHERE ";
				$i = 0;
				foreach ($cond as $key => $val) {
					$add = ($i > 0)?' AND ':'';
					$whereCond .= "$add"."$key=:$key";
					$i ++;
				}
			}

			$sql = "UPDATE ".$table." SET ".$keyvalue.$whereCond;
			$query = $this->pdo->prepare($sql);
			//echo $sql;
			
			foreach ($data as $key => $val) {
				$query->bindValue(":$key", $val);
				//echo $val;
			}

			foreach ($cond as $key => $val) {
				$query->bindValue(":$key", $val);
				//echo $val;
			}

			$update = $query->execute();
			return $update?$query->rowCount():false;
		}else{
			return false;
		}	
	}

// delete method

/*
	$sql = "DELETE FROM tableName WHERE id=:id";
	$query = $this->pdo->prepare($sql);
	$query->bindValue(':id', $id);
	$query->execute();
*/
	public function delete($table, $cond){
		if (!empty($cond) && is_array($cond)) {
			$whereCond .= " WHERE ";
			$i = 0;
			foreach ($cond as $key => $val) {
				$add = ($i > 0)?' AND ':'';
				$whereCond .= "$add"."$key=:$key";
				$i ++;
			}
		}

		$sql = "DELETE FROM ".$table.$whereCond;
		$query = $this->pdo->prepare($sql);
		foreach ($cond as $key => $val) {
			$query->bindValue(":$key", $val);	
		}
		$delete = $query->execute();
		return $delete?true:false;
	}
}
?>