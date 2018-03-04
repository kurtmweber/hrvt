<?php

	class HrvtUserClass{
		private $collections;
		private $userId;
		
		function __construct($user){
			$userId = $user->GetUserId();
			$collections = false;
			}
		
		function Collections(){
			if (!$collections){
				$this->PopulateCollections();
				}
				
			return $collections;
			}
			
		private function PopulateCollections(){
			}
		}

?>