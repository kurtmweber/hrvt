<?php
	require_once(__DIR__ . "/../Database.inc.php");
	require_once(__DIR__ . "/../Config.inc.php");
	
	require_once(__DIR__ . "/HrvtConfig.inc.php");
	
	class Factoid{
		private $factoidId;
		private $ownerId;
		private $creationTime;
		private $updateTime;
		private $title;
		private $value;
		private $startDate;
		private $startDateType;
		private $startDateRelation;
		private $endDate;
		private $endDateType;
		private $endDateRelation;

		function __construct(){
			if (func_num_args() == 2){
				$this->Id(func_get_arg(0));
				$this->Owner(func_get_arg(1));
				
				if (!$this->IsOwner()){
					throw new Exception("Permission denied", HRVT_ERROR_NO_PERMISSION);
					}
					
				$this->Populate();
				return;
				}
			}
			
		function Populate(){
			$conn = GetDatabaseConn();
			
			$stmt = $conn->stmt_init();
			
			if (!$stmt->prepare("SELECT creationTime, updateTime, title, value, comments, startDate, startDateType, startDateRelation, endDate, endDateType, endDateRelation FROM factoids WHERE factoidId = ? AND ownerId = ?")){
				throw new Exception("prepared statement failed", E_PREPARED_STM_UTNRECOV);
				}
				
			$stmt->bind_param("ii", $this->Id(), $this->Owner());
			$stmt->execute();
			$stmt->store_result();
			$stmt->bind_result($ct, $ut, $t, $v, $c, $sd, $sdt, $sdr, $ed, $edt, $edr);
			
			if ($stmt->num_rows == 0){
				throw new Exception("Factoid does not exist", HRVT_ERROR_FACTOID_NOT_EXIST);
				}
				
			$stmt->fetch();
				
			$this->CreationTime($ct);
			$this->UpdateTime($ut);
			$this->Title($t);
			$this->Value($v);
			$this->Comments($c);
			$this->StartDate($sd);
			$this->StartDateType($sdt);
			$this->StartDateRelation($sdr);
			$this->EndDate($ed);
			$this->EndDateType($edt);
			$this->EndDateRelation($edr);
			
			return;
			}

		function IsOwner(){
			if (!$this->Id()){
				return true;
				}
				
			$conn = GetDatabaseConn();
			
			$stmt = $conn->stmt_init();
			if ($stmt->prepare("SELECT * FROM collections WHERE collectionID = ? AND ownerId = ?")){
				$stmt->bind_param("ii", $this->Id(), $this->Owner());
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
		}
?>