<?php
	class Config{
		private $accounts = array(
			0 => array(
				"dataBaseName" => "cn37665_servicec",
				"userName" => "root",
				"password" => ""
			),
			1 => array(
				"dataBaseName" => "cn37665_servicec",
				"userName" => "cn37665_servicec",
				"password" => "1a9a9a2a"
			),
			2 => array(
				"dataBaseName" => "cr47836_servicec",
				"userName" => "cr47836_servicec",
				"password" => "3pkjrPWQQoPo"
			),
		);
		
		private $hostName = 'localhost';
		private $link = false;
		
		private function connect(){
			foreach($this->accounts as $account){
				$this->link = mysql_connect($this->hostName, $account["userName"], $account["password"]);
				if(!$this->link) continue;
				$this->link = mysql_select_db($account["dataBaseName"], $this->link) or 	
				die(mysql_error());
				return true;
			}
			return false;
		}
		
		public function initialisation(){
			return $this->connect();
		}
	}
?>