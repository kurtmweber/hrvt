<?php
	require_once(__DIR__ . "/../Database.inc.php");
	require_once(__DIR__ . "/../Config.inc.php");
	
	require_once(__DIR__ . "/HrvtConfig.inc.php");
	
	class Factoid{
		function __construct(){
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
			}
		}