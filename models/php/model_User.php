<?php
	class User{
		public $firstName = "";
		public $middleName = "";
		public $lastName = "";
		public $login = "";
		public $password = "";
		public $id = "";
		public $idAccessGroup = "";
		public $arr = array();
		
		public function firstWorck(){
			$arrResult = json_decode($this->getInfo(), true);
			if($arrResult["status"] !== true){
				return json_encode(array(
					"act" 		=> __METHOD__." ".__LINE__,
					"status" 	=> false,
					"result"	=> $arrResult
				));
			}
			
			if(count($arrResult["result"]) > 0){
				return json_encode(array(
					"act" 		=> __METHOD__." ".__LINE__,
					"status" 	=> false,
					"result" 	=> count($arrResult["result"])
				));
			}
			
			return json_encode(array(
				"act" 		=> __METHOD__." ".__LINE__,
				"status" 	=> true,
				"result" 	=> count($arrResult["result"])
			));
		}
		
		public function getInfo(){
			$arr = array();
			$query = mysql_query("
				SELECT *
				FROM tb_employee
				WHERE `delete`=0
			") or die(mysql_error()." <b>".__FILE__." ".__LINE__."</b>");
			
			for($i = 0; $i < mysql_num_rows($query); $i++)
				$arr[$i] = mysql_fetch_array($query);
				
			return json_encode(array(
				"act" 		=> __METHOD__." ".__LINE__,
				"status" 	=> true,
				"result" 	=> $arr
			));
		}
		
		
		/*
		return json_encode(array(
			"act" 		=> __METHOD__." ".__LINE__,
			"status" 	=> true,
			"result" 	=> $arr
		));
		*/
		public function getInfoById(){
			$arr = array();
			$query = mysql_query("
				SELECT *
				FROM tb_employee
				WHERE 
					id = '".$this->id."'
					AND
					`delete` = 0
			") or die(mysql_error()." <b>".__FILE__." ".__LINE__."</b>");
			
			$arr = mysql_fetch_array($query);
				
			return json_encode(array(
				"act" 		=> __METHOD__." ".__LINE__,
				"status" 	=> true,
				"result" 	=> $arr
			));
		}
		
		private function createAdmin(){
			mysql_query("
				INSERT INTO employee
				SET 
					first_name='".$this->firstName."',
					middle_name='".$this->middleName."',
					last_name='".$this->lastName."',
					login='".$this->login."',
					password='".md5($this->password)."'
			");
			return true;
		}
		
		public function signIn(){
			$arr = $this->validation();
			$arr = json_decode($arr, true);
			if($arr["status"] !== true){
				return json_encode(array(
					"act" => __CLASS__." -> ".__METHOD__." ".__LINE__,
					"status" => false,
					"result" => $arr
				));
			}
			
			$this->id = $arr["result"];
			
			if($this->accessPermission() !== true){
				return json_encode(array(
					"act" => "signIn > accessPermission",
					"status" => false
				));
			}
			return json_encode(array(
				"act" => "signIn",
				"status" => true
			));
		}
		
		private function validation(){
			$query = mysql_query("
				SELECT id
				FROM tb_employee
				WHERE
					login='".$this->login."'
					AND
					password='".md5($this->password)."'
					AND
					`delete` = 0
			") or die(mysql_error()." <b>".__FILE__." ".__LINE__."</b>");
			
			$row = mysql_fetch_array($query);
			if(($row["id"] === "") || ($row["id"] === NULL)){
				return json_encode(array(
					"act" 		=> __METHOD__." ".__LINE__,
					"status" 	=> false,
					"result" 	=> "validation is ".(int)$row["id"]
				));
			}
			
			return json_encode(array(
				"act" 		=> __METHOD__." ".__LINE__,
				"status" 	=> true,
				"result" 	=> $row["id"]
			));
		}
		
		private function accessPermission(){
			$_COOKIE['id_user'] = $this->id;
			setcookie('id_user', $_COOKIE['id_user'], time() + (3600 * 24 * 365), '/');
			$_COOKIE['id_key'] 	= $this->password;
			setcookie('id_key', md5($_COOKIE['id_key']), time() + (3600 * 24 * 365), '/');
			return true;
		}
		
		public function logout(){
			setcookie('id_user', "", NULL, '/');
			setcookie('id_key', "", NULL, '/');
			return json_encode(array(
				"act" 		=> __METHOD__." ".__LINE__,
				"status" 	=> true,
				"result" 	=> ""
			));
		}
		
		public function status(){
			if((isset($_COOKIE['id_user']) !== true) || ($_COOKIE['id_user'] === ""))
				return json_encode(array(
					"act" 		=> "status",
					"status" 	=> false
				));
			if((isset($_COOKIE['id_key']) !== true) || ($_COOKIE['id_key'] === ""))
				return json_encode(array(
					"act" 		=> "status",
					"status" 	=> false
				));
				
			$this->id 				= $_COOKIE['id_user'];
			$this->password 		= $_COOKIE['id_key'];
			$validationStatus_arr 	= json_decode($this->validationStatus(), true);
			
			if($validationStatus_arr["status"] !== true)
				return json_encode(array(
					"act" 		=> __METHOD__." ".__LINE__,
					"status" 	=> false,
					"result"	=> $validationStatus_arr
				));
				
			$updateLogin_arr 	= json_decode($this->updateLogin(), true);
			
			if($updateLogin_arr["status"] !== true)
				return json_encode(array(
					"act" 		=> __METHOD__." ".__LINE__,
					"status" 	=> false,
					"result" 	=> $updateLogin_arr
				));	
			
			return json_encode(array(
				"act" 		=> __METHOD__." ".__LINE__,
				"status" 	=> true,
				"result" 	=> $validationStatus_arr["result"]["id"]
			));
		}
		
		private function validationStatus(){
			$request = mysql_query("
				SELECT id
				FROM tb_employee
				WHERE
					id='".$this->id."'
					AND
					password='".$this->password."'
					AND
					`delete` = 0
			") or die(mysql_error()." <b>".__FILE__." ".__LINE__."</b>");
			
			$row = mysql_fetch_array($request);
			
			if(($row["id"] === "") || ($row["id"] === NULL))
				return json_encode(array(
					"act" 		=> __METHOD__." ".__LINE__,
					"status" 	=> false,
					"result" 	=> $row["id"]
				));
			
			return json_encode(array(
				"act" 		=> __METHOD__." ".__LINE__,
				"status" 	=> true,
				"result" 	=> $row["id"]
			));
		}
		
		public function registration(){
			$arrResult = json_decode($this->validationRegistrationData(), true);
			if($arrResult["status"] !== true){
				return json_encode(array(
					"act" => __METHOD__." ".__LINE__,
					"status" => false,
					"result" => $arrResult
				));
			}
			
			if($this->createLogin() !== true){
				return json_encode(array(
					"act" => __METHOD__." ".__LINE__,
					"status" => false
				));
			}
			if($this->createPassword() !== true){
				return json_encode(array(
					"act" => __METHOD__." ".__LINE__,
					"status" => false
				));
			}
			if($this->createData() !== true){
				return json_encode(array(
					"act" => __METHOD__." ".__LINE__,
					"status" => false
				));
			}
			return json_encode(array(
				"act" => __METHOD__." ".__LINE__,
				"status" => true,
				"result" => array(
					"login" => $this->login,
					"password" => $this->password
				)
			));
		}
		
		private function validationRegistrationData(){
			$len = 3;
			if(strlen($this->firstName) < $len){
				return json_encode(array(
					"act" => __METHOD__." ".__LINE__,
					"status" => false,
					"result" => "firstName is short!"
				));
			}
			
			if(strlen($this->middleName) < $len){
				return json_encode(array(
					"act" => __METHOD__." ".__LINE__,
					"status" => false,
					"result" => "middleName is short!"
				));
			}
			
			if(strlen($this->lastName) < $len){
				return json_encode(array(
					"act" => __METHOD__." ".__LINE__,
					"status" => false,
					"result" => "lastName is short!"
				));
			}
				
			/*if(strlen($this->password[0]) < 8)
				return json_encode(array(
					"act" => "validationRegistrationData > password length",
					"status" => false,
					"result" => strlen($this->password[0])
				));
				
			if(strcmp($this->password[0], $this->password[1]) !== 0)
				return json_encode(array(
					"act" => "validationRegistrationData > password compare",
					"status" => false,
					"result" => $this->password[0]." != ".$this->password[1]
				));
			*/
			return json_encode(array(
				"act" => __METHOD__." ".__LINE__,
				"status" => true,
				"result" => true
			));
		}
		
		private function createData(){
			mysql_query("
				INSERT INTO tb_employee
				SET 
					first_name='".$this->firstName."',
					middle_name='".$this->middleName."',
					last_name='".$this->lastName."',
					login='".$this->login."',
					password='".md5($this->password)."',
					id_access_group='".$this->idAccessGroup."'
			") or die(mysql_error()." <b>".__FILE__." ".__LINE__."</b>");
			return true;
		}
		
		private function findeMaxId($table){
			$query = mysql_query("
				SELECT id
				FROM ".$table."
				ORDER BY id DESC
			") or die(mysql_error()." <b>".__FILE__." ".__LINE__."</b>");
			
			$row = mysql_fetch_array($query);
			return $row['id'];
		}
		
		private function createLogin(){
			$this->login = $this->lastName."_".substr($this->firstName, 0, 2);
			
			$Grammar = new Grammar();
			$this->login = $Grammar->rusToLatinTranslation($this->login)."".((int)$this->findeMaxId("tb_employee") + 1);
			return true;
		}
		
		private function createPassword(){
			$this->password = rand(100000, 999999);
			return true;
		}
		
		public function passwordRecovery(){
			$this->createPassword();
			mysql_query("
				UPDATE tb_employee
				SET password = '".md5($this->password)."'
				WHERE 
					id = '".$this->id."'
					AND
					`delete` = 0
			") or die(mysql_error()." <b>".__FILE__." ".__LINE__."</b>");
			
			$getInfoById_arr = json_decode($this->getInfoById(), true);
			
			return json_encode(array(
				"act" 		=> __METHOD__." ".__LINE__,
				"status" 	=> true,
				"result" 	=> array(
					"login" 	=> $getInfoById_arr["result"]["login"],
					"password" 	=> $this->password
				)
			));
		}
		
		public function getRankById(){
			$arr = array();
			$query = mysql_query("
				SELECT id_access_group
				FROM tb_employee
				WHERE 
					id = '".$this->id."'
					AND
					`delete` = 0
			") or die(mysql_error()." <b>".__FILE__." ".__LINE__."</b>");
			
			$arr = mysql_fetch_array($query);
			
			if(!class_exists('AccessGroup'))
				include ($_SERVER['DOCUMENT_ROOT']."/models/php/model_AccessGroup.php");
			$AccessGroup = new AccessGroup();
			$AccessGroup->id = $arr["id_access_group"];
			$accessGroup_getRankById_arr = json_decode($AccessGroup->getRankById(), true);
			if($accessGroup_getRankById_arr["status"] !== true)
				return json_encode(array(
					"act" 		=> __METHOD__." ".__LINE__,
					"status" 	=> false,
					"result" 	=> $accessGroup_getRankById_arr
				));
			
			
			return json_encode(array(
				"act" 		=> __METHOD__." ".__LINE__,
				"status" 	=> true,
				"result" 	=> $accessGroup_getRankById_arr["result"]["rank"]
			));
		}
		
		public function deleteById(){
			if($_COOKIE['id_user'] === $this->id)
				return json_encode(array(
					"act" 		=> __METHOD__." ".__LINE__,
					"status" 	=> false,
					"result" 	=> "self-extinction"
				));
			
			$query = mysql_query("
				UPDATE tb_employee
				SET `delete` = 1
				WHERE `id` = '".$this->id."'
			") or die(mysql_error()." <b>".__FILE__." ".__LINE__."</b>");
			
			return json_encode(array(
				"act" 		=> __METHOD__." ".__LINE__,
				"status" 	=> true,
				"result" 	=> $query
			));
		}
		
		private function updateLogin(){
			//echo time();
			$query = mysql_query("
				UPDATE tb_employee
				SET date = NOW()
				WHERE 
					id='".$this->id."'
					AND
					`delete` = 0
			") or die(mysql_error()." <b>".__FILE__." ".__LINE__."</b>");
			
			return json_encode(array(
				"act" 		=> __METHOD__." ".__LINE__,
				"status" 	=> true,
				"result" 	=> $query
			));
		}
	}
?>