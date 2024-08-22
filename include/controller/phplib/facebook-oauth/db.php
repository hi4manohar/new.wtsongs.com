<?php 
	class dbconn extends PDO {		
		function __construct($dsn, $username="", $password="", $driver_options=array()) {
			parent::__construct($dsn,$username,$password, $driver_options);
		}
		function getDataFromQuery($qry) {
			$stmt = $this->prepare($qry);
			$stmt->execute();
			$res_result = $stmt->fetch();
			if(count($res_result)>0) {
				return $res_result;
			} else {
				return false;
			}
		}
		function getDataListFromQuery($qry) {
			$stmt = $this->prepare($qry);
			$stmt->execute();
			$res_result = $stmt->fetchAll();
			if(count($res_result)>0) {
				return $res_result;
			} else {
				return false;
			}
		}
		function UpdateQuery($qry) {
			$stmt = $this->prepare($qry);
			$stmt->execute();
			return $this->lastInsertId(); 
		}
	}
	
	$db = new dbconn('mysql:host=localhost;dbname=wtsongs','root','');
?>
