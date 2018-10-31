<?php
	class GuestEntered{
		public $isExit = false;
		public $bailReturned = false;
		public $depositCanBeTransferred = false;
		public $idApartmentState = "";
		public $idEmployee = "";
		public $numberOfChildren = 0;
		public $numberOfAdults = 0;
		public $dateEntry = "";
		
		public function initByIdApartmentState(){
			$arr = json_decode($this->getInfoByIdApartmentState(), true);				// узнаем информацтю о заезде
			if($arr["status"] !== true){												// если ошибка
				return json_encode(array(												// выводим ошибку
					"act" => __CLASS__." -> ".__METHOD__." ".__LINE__,
					"status" => false,
					"result" => $arr
				));
			}
			
			if(($arr["result"]["id"] === "") || ($arr["result"]["id"] === NULL)){		// если информации о заезде нет
				$arr = json_decode($this->creadeData(),true);							// создаем заезд
				if($arr["status"] !== true){ 											// если при создании заезда возникда ошибка
					return json_encode(array(											// выводим ошибку
						"act" => __CLASS__." -> ".__METHOD__." ".__LINE__,
						"status" => false,
						"result" => $arr
					));
				}
			} else if(($arr["result"][0]["id"] !== "") && ($arr["result"][0]["id"] !== NULL)){	// если иформация о заезде есть
				return json_encode(array(													// выводим информацию
					"act" => __CLASS__." -> ".__METHOD__." ".__LINE__,
					"status" => true,
					"result" => $arr
				));
			}
		}
		
		public function sendDataByApartmentState(){
			mysql_query("
				UPDATE tb_entry
				SET
					number_of_adults = '".$this->numberOfAdults."',
					number_of_children = '".$this->numberOfChildren."',
					amount_in_cash='".$this->amountInCash."',
					pledge='".$this->pledge."',
					date_entry='".$this->dateEntry."',
					id_employee='".$this->idEmployee."'
				WHERE
					id_apartment_state='".$this->idApartmentState."'
			") or die(mysql_error()." <b>".__FILE__." ".__LINE__."</b>");
			
			return json_encode(array(
				"act" => __CLASS__." -> ".__METHOD__." ".__LINE__,
				"status" => true,
				"result" => true
			));
		}
		
		private function creadeData(){
			mysql_query("
				INSERT INTO tb_entry
				SET
					id_apartment_state 	= '".$this->idApartmentState."',
					id_employee 		= '".$this->idEmployee."',
					date_entry 			= '".date("Y-m-d")."'
			") or die(mysql_error()." <b>".__FILE__." ".__LINE__."</b>");
			
			return json_encode(array(
				"act" => __CLASS__." -> ".__METHOD__." ".__LINE__,
				"status" => true,
				"result" => true
			));
		}
		
		public function getInfoByIdApartmentState(){
			$query = mysql_query("
				SELECT *
				FROM tb_entry
				WHERE id_apartment_state='".$this->idApartmentState."'
			") or die(mysql_error()." <b>".__FILE__." ".__LINE__."</b>");
			
			$arr = mysql_fetch_array($query);
			return json_encode(array(
				"act" => __CLASS__." -> ".__METHOD__." ".__LINE__,
				"status" => true,
				"result" => $arr
			));
		}
		
		public function getInfoByIdApartmentStateAndDateEntry(){
			$query = mysql_query("
				SELECT *
				FROM tb_entry
				WHERE 
					id_apartment_state = '".$this->idApartmentState."'
					AND
					date_entry = '".$this->dateEntry."'
			") or die(mysql_error()." <b>".__FILE__." ".__LINE__."</b>");
			
			$arr = mysql_fetch_array($query);
			return json_encode(array(
				"act" => __CLASS__." -> ".__METHOD__." ".__LINE__,
				"status" => true,
				"result" => $arr
			));
		}
	}
?>