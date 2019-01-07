<?php
	require_once(__DIR__ . "/../HrvtConfig.inc.php");

	class Calendar{
		private $supportedTypes;
		private $julianDayNum;

		function __construct(){
			$supportedTypes = array("gregorian","julian","french","hebrew");
			
			if (func_num_args() == 4){
				if (!in_array(func_get_arg(3), $this->supportedTypes)){
					throw new Exception("Unsupported calendar type", HRVT_ERROR_INVALID_CALENDAR);
					}

				$year = func_get_arg(0);
				$month = func_get_arg(1);
				$day = func_get_arg(2);
				
				
				}
			}

		function enumerateSupportedTypes(){
			return $supportedTypes;
			}
		}

?>