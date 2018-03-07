<?php
	require_once(__DIR__ . "/../Database.inc.php");
	require_once(__DIR__ . "/../Config.inc.php");
	
	class Collection{
		private $collId;
		private $ownerId;
		private $creationTime;
		private $updateTime;
		private $title;
		private $description;
		
		function __construct(){
			$this->collId = false;
			$this->ownerId = false;
			$this->creationTime = false;
			$this->updateTime = false;
			$this->title = false;
			$this->description = false;
			
			if (func_num_args() == 6){
				$this->Id(func_get_arg(0));
				$this->Owner(func_get_arg(1));
				$this->CreationTime(func_get_arg(2));
				$this->UpdateTime(func_get_arg(3));
				$this->Title(func_get_arg(4));
				$this->Description(func_get_arg(5));
				return;
				}
				
			if (func_num_args() == 3){
				$this->Owner(func_get_arg(0));
				$this->Title(func_get_arg(1));
				$this->Description(func_get_arg(2));
				return;
				}
			
			return;
			}
			
		function Store(){
			if (!$this->IsOwner()){
				throw new Exception("No permission to make changes", HRVT_ERROR_NO_PERMISSION);
				}
				
			$conn = GetDatabaseConn();
			
			$stmt = $conn->stmt_init();
			
			if (!($this->Id())){
				if (!($stmt->prepare("INSERT INTO collections VALUES(NULL, ?, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, ?, ?)"))){
					print_r($stmt->error);
					throw new Exception("prepared statement failed", E_PREPARED_STMT_UNRECOV);
					}
				$stmt->bind_param("iss", $this->Owner(), $this->Title(), $this->Description());
				} else {
				if (!($stmt->prepare("UPDATE collections SET title=?, description=? WHERE collectionId=?"))){
					throw new Exception("prepared statement failed", E_PREPARED_STMT_UNRECOV);
					}
				$stmt->bind_param("ssi", $this->Title(), $this->Description, $this->Id());
				}
				
			$stmt->execute();
			}
			
		function IsOwner(){
			if (!$this->Id()){
				return true;
				}
				
			$conn = GetDatabaseConn();
			
			$stmt = $conn->stmt_init();
			if ($stmt->prepare("SELECT * FROM collections WHERE collectionID = ? AND ownerId = ?")){
				$stmt->bind_param("ii", $this->Id(), $this->ownerId());
				$stmt->execute();
				$stmt->store_result();
				if ($stmt->num_rows != 0){
					return true;
					} else {
					return false;
					}
				} else {
				throw new Exception("prepared statement failed", E_PREPARED_STMT_UNRECOV);
				}
			}
			
		function Id(){
			if (func_num_args() == 1){
				$this->collId = func_get_arg(0);
				}
				
			return $this->collId;
			}
			
		function Owner(){
			if (func_num_args() == 1){
				$this->ownerId = func_get_arg(0);
				}
			return $this->ownerId;
			}
			
		function CreationTime(){
			if (func_num_args() == 1){
				$this->creationTime = new DateTime(func_get_arg(0));
				}
			return $this->creationTime;
			}
			
		function UpdateTime(){
			if (func_num_args() == 1){
				$this->updateTime = new DateTime(func_get_arg(0));
				}
			return $this->updateTime;
			}
			
		function Title(){
			if (func_num_args() == 1){
				$this->title = func_get_arg(0);
				}
			return $this->title;
			}
			
		function Description(){
			if (func_num_args() == 1){
				$this->description = func_get_arg(0);
				}
			return $this->description;
			}
		}
?>