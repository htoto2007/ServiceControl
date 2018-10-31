<?php
	class GuestLeft{
		public $isExit 					= false;
		public $bailReturned 			= false;
		public $depositCanBeTransferred = false;
		public $idApartmentState 		= "";
		public $idEmployee 				= "";
		public $dateExit 				= "";
		
		public function initByIdApartmentState(){
			$arr = json_decode($this->getInfoByIdApartmentState(), true);				// узнаем информацтю о выезде
			if($arr["status"] !== true){												// если ошибка
				return json_encode(array(												// выводим ошибку
					"act" 		=> __CLASS__." -> ".__METHOD__." ".__LINE__,
					"status" 	=> false,
					"result" 	=> $arr
				));
			}
			
			if(($arr["result"]["id"] === "") || ($arr["result"]["id"] === NULL)){		// если информации о выезде нет
				$arr = json_decode($this->creadeData(),true);							// создаем выезд
				if($arr["status"] !== true){ 											// если при создании выезда возникда ошибка
					return json_encode(array(											// выводим ошибку
						"act" 		=> __CLASS__." -> ".__METHOD__." ".__LINE__,
						"status" 	=> false,
						"result" 	=> $arr
					));
				}
			} else if(($arr["result"]["id"] !== "") && ($arr["result"]["id"] !== NULL)){	// если иформация о выезде есть
				return json_encode(array(													// выводим информацию
					"act" 		=> __CLASS__." -> ".__METHOD__." ".__LINE__,
					"status" 	=> true,
					"result" 	=> $arr
				));
			}
		}
		
		public function sendData(){
			mysql_query("
				UPDATE tb_exit
				SET
					is_exit 					= '".$this->isExit."',
					bail_returned 				= '".$this->bailReturned."',
					deposit_can_be_transferred 	= '".$this->depositCanBeTransferred."',
					id_employee 				= '".$this->idEmployee."',
					date_exit 					= '".$this->dateExit."'
				WHERE
					id_apartment_state 			= '".$this->idApartmentState."'
			") or die(mysql_error()." <b>".__FILE__." ".__LINE__."</b>");
				
			return json_encode(array(
				"act" 		=> __CLASS__." -> ".__METHOD__." ".__LINE__,
				"status" 	=> true,
				"result" 	=> true
			));
		}
		
		private function creadeData(){
			mysql_query("
				INSERT INTO tb_exit
				SET
					id_apartment_state 	= '".$this->idApartmentState."',
					id_employee 		= '".$this->idEmployee."'
			") or die(mysql_error()." <b>".__FILE__." ".__LINE__."</b>");
			
			return json_encode(array(
				"act" 		=> __CLASS__." -> ".__METHOD__." ".__LINE__,
				"status" 	=> true,
				"result" 	=> true
			));
		}
		
		public function getInfoByIdApartmentState(){
			$query = mysql_query("
				SELECT *
				FROM tb_exit
				WHERE id_apartment_state = '".$this->idApartmentState."'
			") or die(mysql_error()." <b>".__FILE__." ".__LINE__."</b>");
			
			$arr = mysql_fetch_array($query);
			return json_encode(array(
				"act" 		=> __CLASS__." -> ".__METHOD__." ".__LINE__,
				"status" 	=> true,
				"result" 	=> $arr
			));
		}
		
		public function getInfoByIdApartmentStateAndDateExit(){
			$query = mysql_query("
				SELECT *
				FROM tb_exit
				WHERE 
					id_apartment_state = '".$this->idApartmentState."'
					AND
					date_exit = '".$this->dateExit."'
			") or die(mysql_error()." <b>".__FILE__." ".__LINE__."</b>");
			
			$arr = mysql_fetch_array($query);
			return json_encode(array(
				"act" 		=> __CLASS__." -> ".__METHOD__." ".__LINE__,
				"status" 	=> true,
				"result" 	=> $arr
			));
		}
	}
?>