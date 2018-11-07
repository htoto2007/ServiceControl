<?php
	class ApartmentCleaning{
		
		public $id = 0;
		public $idApartment = 0;
		public $idEmployee = 0;
		public $date = "01-01-1970";
		public $startDate = "01-01-1970";
		public $endDate = "01-01-1970";
		
		
		
		public function getInfoByDateAndIdApartment(){
			$query = mysql_query("
				SELECT * 
				FROM  tb_apartment_cleaning 
				WHERE
					id_apartment = '".$this->idApartment."'
					AND 
					date = DATE('".$this->date."')
			") or die(mysql_error()." <b>".__FILE__." ".__LINE__."</b>");
			$row = array();
			//for($i = 0; $i < mysql_num_rows($query); $i++){
				$row = mysql_fetch_array($query);
			//}
			
			return json_encode(array(									// выводим результат
				"act" 		=> __METHOD__." ".__LINE__,
				"status" 	=> true,
				"result" 	=> $row
			));
		}
		
		public function getInfoByDatePeriodAndIdApartment(){
			$query = mysql_query("
				SELECT * 
				FROM  tb_apartment_cleaning 
				WHERE
					id_apartment = '".$this->idApartment."'
					AND 
					date <= DATE('".$this->startDate."') 
					AND 
					date >= DATE('".$this->endDate."')
			") or die(mysql_error()." <b>".__FILE__." ".__LINE__."</b>");
			$row = array();
			for($i = 0; $i < mysql_num_rows($query); $i++){
				$row[$i] = mysql_fetch_array($query);
			}
			
			return json_encode(array(									// выводим результат
				"act" 		=> __METHOD__." ".__LINE__,
				"status" 	=> true,
				"result" 	=> $row
			));
		}
		
		public function getInfoByDateAndIdApartmentAndIdEmployee(){
			$query = mysql_query("
				SELECT * 
				FROM  tb_apartment_cleaning 
				WHERE
					id_apartment = '".$this->idApartment."' 
					AND 
					date = DATE('".$this->date."') 
					AND 
					id_employee = '".$this->idEmployee."'
			") or die(mysql_error()." <b>".__FILE__." ".__LINE__."</b>");
			$rows = array();
			for($i = 0; $i < mysql_num_rows($query); $i++){
				$rows[$i] = mysql_fetch_array($query);
			}
			return json_encode(array(									// выводим результат
				"act" 		=> __METHOD__." ".__LINE__,
				"status" 	=> true,
				"result" 	=> $rows
			));
		}
		
		public function add(){
			$query = mysql_query("
				INSERT INTO tb_apartment_cleaning 
				SET
					id_apartment = '".$this->idApartment."',
					id_employee = '".$this->idEmployee."',
					date = DATE('".$this->date."')
			") or die(mysql_error()." <b>".__FILE__." ".__LINE__."</b>");
			
			return json_encode(array(									// выводим результат
				"act" 		=> __METHOD__." ".__LINE__,
				"status" 	=> true,
				"result" 	=> mysql_insert_id()
			));
		}
		
		public function deleteById(){
			$query = mysql_query("
				DELETE FROM tb_apartment_cleaning 
				WHERE `id` = '".$this->id."'
			") or die(mysql_error()." <b>".__FILE__." ".__LINE__."</b>");
			
			return json_encode(array(									// выводим результат
				"act" 		=> __METHOD__." ".__LINE__,
				"status" 	=> true,
				"result" 	=> NULL
			));
		}
	}
?>