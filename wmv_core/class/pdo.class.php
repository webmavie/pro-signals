<?php
class wmvpdo {
	private $db_host;
	private $db_user;
	private $db_password;
	private $db_name;
	public $db;
	public $db_perfix;

	function __construct ($db_host="", $db_user="", $db_password="", $db_name="", $db_perfix="") {
		if (strpos($db_perfix, "_")==TRUE or $db_perfix=="") {
		$prfx=$db_perfix;
		}else {
		$prfx=$db_perfix.'_';
		}
		$this->perfix = $prfx;

		try {
			$db=new PDO("mysql:host=".$db_host.";dbname=".$db_name.";charset=utf8",$db_user,$db_password);
			$this->db=$db;
		} catch (Exception $e) {
		 	echo $e->getMessage();
		 	exit();
		} 
	}

	public function arraytopdo($data=array()){
		$whatcount=@count($data)-1;
		if ($whatcount < 0){die;}
		$newdata="";
		$i=0;
		foreach ($data as $key => $value) {
			$comma=$i==$whatcount?"":",";
			$newdata.="`{$key}` = '{$value}'{$comma} \n";
			$i++;
		}

		return $newdata;
	}

	function get_onerow($colum="", $where=array()){
		$pdo=$this->db;
		$prfx=$this->perfix;
		$colum=str_replace($prfx, "", $colum);

		if (@count($where) > 0) {
			$where='WHERE ' . str_replace(", ", " AND ", $this->arraytopdo($where));
		}

		$select=$pdo->prepare("SELECT * FROM {$prfx}{$colum} {$where}"); 
		$select->execute(array());
		$select=$select->fetch(PDO::FETCH_ASSOC);

		return $select;
	}

	function get_allrow($colum="", $where=array(), $orderby="", $list="ASC", $limit=0, $offset=0){
		$pdo=$this->db;
		$prfx=$this->perfix;
		$colum=str_replace($prfx, "", $colum);

		if (@count($where) > 0 AND $where!=="no") {
			$where='WHERE ' . str_replace(", ", " AND ", $this->arraytopdo($where));
		}
		if ($orderby!=="") {
			$orderby="ORDER BY `{$orderby}` {$list}";
		}

		if ($limit!==0) {
			$limit_offset="LIMIT {$limit}, $offset";
		}

		$select=@$pdo->prepare("SELECT * FROM {$prfx}{$colum} {$where} {$orderby} {$limit_offset}");
        $select->execute(array());
        $select = $select->fetchAll(PDO::FETCH_ASSOC);

        $data=array();
        foreach ($select as $key => $value) {
        		$data[$key]=$value;
        }

        return $select;
	}

	function add_row($colum="", $data=array()){
		$pdo=$this->db;
		$prfx=$this->perfix;
		$data=$this->arraytopdo($data);
		$colum=str_replace($prfx, "", $colum);

		$insert = $pdo->prepare("INSERT INTO {$prfx}{$colum} SET {$data} ");
		$insert = $insert->execute(array());

		return $insert;
	}
	

	function delete_row($colum="", $where=array()){
		$pdo=$this->db;
		$prfx=$this->perfix;
		$where=str_replace(", ", " AND ", $this->arraytopdo($where));
		$colum=str_replace($prfx, "", $colum);

		$delete=$pdo->prepare("DELETE FROM {$prfx}{$colum} WHERE {$where}");
        $delete->execute(array());

        if (!$delete) {
        	return FALSE;
        }else {
        	return TRUE;
        }
	}

	function update_row($colum="", $where=array(), $data=array()){
		$pdo=$this->db;
		$prfx=$this->perfix;
		$data=$this->arraytopdo($data);
		$where=str_replace(", ", " AND ", $this->arraytopdo($where));
		$colum=str_replace($prfx, "", $colum);

		$update=$pdo->prepare("UPDATE {$prfx}{$colum} SET 
			{$data}
			WHERE {$where}");
		$update=$update->execute(array());
		return $update;
	}

	function count_row($colum, $where=array()){
		$pdo=$this->db;
		$prfx=$this->perfix;
		if (@count($where) > 0 AND $where!=="no") {
			$where='WHERE ' . str_replace(", ", " AND ", $this->arraytopdo($where));
		}
		$colum=str_replace($prfx, "", $colum);

		$count=$pdo->query("SELECT COUNT(*) AS num FROM {$prfx}{$colum} {$where}")->fetchColumn(); 

		return $count;
	}

	function like($colum, $where, $search){
		$pdo=$this->db;
		$prfx=$this->perfix;
		$colum=str_replace($prfx, "", $colum);

		$query = $pdo->prepare("SELECT * FROM {$prfx}{$colum} WHERE {$where} LIKE '%{$search}%'");
		$query->execute(array());
		$result = $query->fetchAll(PDO::FETCH_ASSOC);

		return $result;
	}

	function console($code){
		$pdo=$this->db;
		$console=$pdo->prepare("$code");
		$console->execute(array());

		$console = $console->fetchAll(PDO::FETCH_ASSOC);
		return $console;
	}

	function escape_string($string) {
		$pdo=$this->db;
		return $pdo->quote($string);
	}

	function lastid() {
		$pdo=$this->db;
		return $pdo->query("SELECT LAST_INSERT_ID() AS lastid")->fetchColumn(); 
	}

}
?>