<?php
	require_once(__DIR__ . "/../Database.inc.php");
	require_once(__DIR__ . "/../Config.inc.php");
	
	require_once(__DIR__ . "/./CollectionsClass.inc.php");

	class HrvtUserClass{
		private $collections;
		private $userId;
		
		function __construct($user){
			$this->userId = $user->GetUserId();
			$this->collections = false;
			}
		
		function Collections(){
			if (!$this->collections){
				$this->PopulateCollections();
				}
				
			return $this->collections;
			}
			
		private function PopulateCollections(){
			$conn = GetDatabaseConn();
			
			$stmt = $conn->stmt_init();
			if ($stmt->prepare("SELECT * from collections WHERE ownerId = ?")){
				$stmt->bind_param("i", $this->userId);
				$stmt->bind_result($collectionId, $ownerId, $creationTime, $updateTime, $title, $description);
				$stmt->execute();
				
				$numRows = 0;
				while ($stmt->fetch()){
					$numRows++;
					$collInfo[] = array($collectionId, $ownerId, $creationTime, $updateTime, $title, $description);
					}
				} else {
				throw new Exception("prepared statement failed", E_PREPARED_STMT_UNRECOV);
				}
				
			if (!$numRows){
				$this->collections = false;
				} else {
				foreach ($collInfo as $curColl){
					$this->collections[] = new Collection($curColl[0], $curColl[1], $curColl[2], $curColl[3], $curColl[4], $curColl[5]);
					}
				}
			}
		}

?>