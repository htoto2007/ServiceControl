<?php
	class AccessToApartments{
		public $idApartment = 0;
		public $idEmployee = 0;
		public $id = 0;
		
		public function send(){
			$this->deleteByIdEmployee();
			$arr = $this->idApartment;
			foreach($arr as $id){
				$this->idApartment = $id;
				$this->create();
			}
			
			return json_encode(array(
				"act" 		=> __METHOD__." ".__LINE__,
				"status" 	=> true,
				"result" 	=> ""
			));
		}
		
		private function create(){
			mysql_query("
				INSERT INTO tb_access_to_apartments
				SET
					id_employee = '".$this->idEmployee."',
					id_apartment = '".$this->idApartment."'
			") or die(mysql_error()." <b>".__FILE__." ".__LINE__."</b>");
			
			return json_encode(array(
				"act" 		=> __METHOD__." ".__LINE__,
				"status" 	=> true,
				"result" 	=> $this->arr
			));
		}
		
		private function deleteByIdEmployee(){
			mysql_query("
				DELETE FROM tb_access_to_apartments
				WHERE
					id_employee = '".$this->idEmployee."'
			") or die(mysql_error()." <b>".__FILE__." ".__LINE__."</b>");
			
			return json_encode(array(
				"act" 		=> __METHOD__." ".__LINE__,
				"status" 	=> true,
				"result" 	=> $this->arr
			));
		}
		
		public function getInfoByIdApartment(){
			$arr = array();
			$query = mysql_query("
				SELECT * 
				FROM tb_access_to_apartments
				WHERE
					id_apartment = '".$this->idApartment."'
			") or die(mysql_error()." <b>".__FILE__." ".__LINE__."</b>");
			
			for($i = 0; $i < mysql_num_rows($query); $i++)
				$arr[$i] = mysql_fetch_array($query);
			
			return json_encode(array(
				"act" 		=> __METHOD__." ".__LINE__,
				"status" 	=> true,
				"result" 	=> $arr
			));
		}
		
		public function getInfoByIdEmployeeAndIdApartment(){
			$arr = array();
			$query = mysql_query("
				SELECT * 
				FROM tb_access_to_apartments
				WHERE
					id_employee = '".$this->idEmployee."'
					AND
					id_apartment = '".$this->idApartment."'
			") or die(mysql_error()." <b>".__FILE__." ".__LINE__."</b>");
			
			//for($i = 0; $i < mysql_num_rows($query); $i++)
				$arr = mysql_fetch_array($query);
			
			return json_encode(array(
				"act" 		=> __METHOD__." ".__LINE__,
				"status" 	=> true,
				"result" 	=> $arr
			));
		}
		
		public function getInfoByIdEmployee(){
			$arr = array();
			$query = mysql_query("
				SELECT * 
				FROM tb_access_to_apartments
				WHERE
					id_employee = '".$this->idEmployee."'
			") or die(mysql_error()." <b>".__FILE__." ".__LINE__."</b>");
			
			for($i = 0; $i < mysql_num_rows($query); $i++)
				$arr[$i] = mysql_fetch_array($query);
			
			return json_encode(array(
				"act" 		=> __METHOD__." ".__LINE__,
				"status" 	=> true,
				"result" 	=> $arr
			));
		}
	}
?>