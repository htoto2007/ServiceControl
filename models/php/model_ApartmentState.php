<?php
	class  ApartmentState{
		public $id 						= "";
		public $idApartment 			= "";
		public $numberOfPersons 		= "";
		public $amountInCash 			= "";
		public $apartmentIsReady 		= false;
		public $dateValue				= "";
		public $dateStart				= "";
		public $dateEnd					= "";
		public $idEmployee				= 0;
		
		public $numberOfChildren 		= 0;
		public $numberOfAdults 			= 0;
		public $dateEntry 				= "";
		public $pledge 					= false;
		
		public $isExit 					= false;
		public $bailReturned 			= false;
		public $depositCanBeTransferred = false;
		public $dateExit 				= "";
		public $amountInCashSsReceived	= false;
		
		public function initDataByIdApartment(){
			//$this->create();
			$arrResult = $this->getApartmentStateIdByIdApartment();				// проверяем последнюю статистику по квартире
			$arrResult = json_decode($arrResult, true);
			/*echo "<pre>";
			var_dump($arrResult);
			echo "</pre>";*/
			if($arrResult["result"][0]["id"] === NULL){	 						// если статистики нет
				$arrResult = json_decode($this->create(), true);				// создаем статистику
				if($arrResult["status"] !== true){
					return json_encode(array(									// выводим ошибку
						"act" 		=> __METHOD__." ".__LINE__,
						"status" 	=> false,
						"result" 	=> $arrResult
					));
				}else {
					return json_encode(array(									// выводим результат
						"act" 		=> __METHOD__." ".__LINE__,
						"status" 	=> true,
						"result" 	=> $arrResult["result"]
					));
				}
			} else if(($arrResult["status"] === true) && ($arrResult["result"] !== NULL)){	// если статистика есть
				$arrResult = $this->getReadyByIdApartment(); 					// проверяем готовность квартиры
				$arrResult = json_decode($arrResult, true);
				/*echo "<pre>";
				var_dump($arrResult["result"]);
				echo "</pre>";*/
				if($arrResult["result"][0]["apartment_is_ready"] === false){	// если не готова
					$arrResult = $this->getInfoByIdApartment(); 				// выводим информацию
					$arrResult = json_decode($arrResult, true);
					/*echo "<pre>";
					var_dump($arrResult);
					echo "</pre>";*/
					if($arrResult["status"] === false){							// Если ошибка вывода
						return json_encode(array(								// выводим ошибку
							"act" 		=> __METHOD__." ".__LINE__,
							"status" 	=> false,
							"result" 	=> $arrResult
						));
					}else if($arrResult["status"] === true){					// если вывод без ошибок
						return json_encode(array(								// выводим статистику
							"act" 		=> __METHOD__." ".__LINE__,
							"status" 	=> true,
							"result" 	=> $arrResult
						));
					}
				} else if($arrResult["result"][0]["apartment_is_ready"] === true){					// если квартира готова
					$arrResult = json_decode($this->create(), true);			// создаем статистику
					if($arrResult["status"] !== true){							// если что-то не так
						return json_encode(array(								// выводим ошибку
							"act" 		=> __METHOD__." ".__LINE__,
							"status" 	=> false,
							"result" 	=> $arrResult
						));
					}else {														// если ошибок нет
						return json_encode(array(								// выводим результат
							"act" 		=> __METHOD__." ".__LINE__,
							"status" 	=> true,
							"result" 	=> $arrResult["result"]
						));
					}
				}
			}
			
			return json_encode(array(											// выводим ошибку
				"act" 		=> __METHOD__." ".__LINE__,
				"status" 	=> false,
				"result" 	=> false
			));
		}
		
		private function create(){
			mysql_query("
				INSERT INTO tb_apartment_state
				SET id_apartment = '".$this->idApartment."'
			") or die(mysql_error()." <b>".__FILE__." ".__LINE__."</b>");
			
			return json_encode(array(
				"act" 		=> __METHOD__." ".__LINE__,
				"status" 	=> true,
				"result" 	=> mysql_insert_id()
			));
		}
		
		public function deleteById(){
			if("" == $this->id)
				return json_encode(array(
					"act" 		=> __METHOD__." ".__LINE__,
					"status" 	=> false,
					"result" 	=> "self-extinction"
				));
			
			$query = mysql_query("
				UPDATE tb_apartment_state
				SET `delete` = 1
				WHERE `id` = '".$this->id."'
			") or die(mysql_error()." <b>".__FILE__." ".__LINE__."</b>");
			
			return json_encode(array(
				"act" 		=> __METHOD__." ".__LINE__,
				"status" 	=> true,
				"result" 	=> $query
			));
		}
		
		private function getReadyByIdApartment(){
			$query = mysql_query("
				SELECT apartment_is_ready
				FROM tb_apartment_state
				WHERE 
					id_apartment = '".$this->idApartment."'
					AND
					`delete` = 0
				ORDER BY id DESC
			") or die(mysql_error()." <b>".__FILE__." ".__LINE__."</b>");
			
			for($i = 0; $i < mysql_num_rows($query); $i++){
				$arr[$i] = mysql_fetch_array($query);
				$arr[$i]["apartment_is_ready"] = (bool)$arr[$i]["apartment_is_ready"];
			}
			
			return json_encode(array(
				"act" 		=> __METHOD__." ".__LINE__,
				"status" 	=> true,
				"result" 	=> $arr
			));
		}
		
		public function getApartmentStateIdByIdApartment(){
			$query = mysql_query("
				SELECT id
				FROM tb_apartment_state
				WHERE 
					id_apartment = '".$this->idApartment."'
					AND
					`delete` = 0
				ORDER BY id DESC
			") or die(mysql_error()." <b>".__FILE__." ".__LINE__."</b>");
			
			for($i = 0; $i < mysql_num_rows($query); $i++)
				$arr[$i] = mysql_fetch_array($query);
			
			return json_encode(array(
				"act" 		=> __METHOD__." ".__LINE__,
				"status" 	=> true,
				"result" 	=> $arr
			));
		}
		
		public function getInfoByIdApartment(){
			$query = mysql_query("
				SELECT *
				FROM tb_apartment_state
				WHERE 
					id_apartment = '".$this->idApartment."'
					AND
					`delete` = 0
				ORDER BY id DESC
			") or die(mysql_error()." <b>".__FILE__." ".__LINE__."</b>");
			
			for($i = 0; $i < mysql_num_rows($query); $i++)
				$arr[$i] = mysql_fetch_array($query);
			
			return json_encode(array(
				"act" 		=> __METHOD__." ".__LINE__,
				"status" 	=> true,
				"result" 	=> $arr
			));
		}
		
		public function getInfoById(){
			$arr = array();
			$query = mysql_query("
				SELECT *
				FROM tb_apartment_state
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
		
		public function getInfoByIdApartmentAndDates(){
			$query = mysql_query("
				SELECT *
				FROM tb_apartment_state
				WHERE 
					id_apartment = '".$this->idApartment."'
					AND
					date_exit 	>= DATE('".$this->dateValue."')
					AND
					date_entry 	<= DATE('".$this->dateValue."')
					AND
					`delete` = 0
				ORDER BY date_entry
			") or die(mysql_error()." <b>".__FILE__." ".__LINE__."</b>");

			for($i = 0; $i < mysql_num_rows($query); $i++){
				$arr[$i] 				= mysql_fetch_array($query);
				$this->dateEntry 		= $arr[$i]["date_entry"];
				$this->dateExit 		= $arr[$i]["date_exit"];
				
				$totalDays 				= json_decode($this->getCountDaysByPeriodDate(), true);
				$this->dateEntry		= $this->dateValue;
				
				$daysLeft 				= json_decode($this->getCountDaysByPeriodDate(), true);
				$arr[$i]["daysLeft"] 	= $daysLeft["result"];
				$arr[$i]["totalDays"] 	= $totalDays["result"];
				if((float)$arr[$i]["totalDays"] > 0)
					$arr[$i]["costPerDay"]	= round(((float)$arr[$i]["amount_in_cash"] / (float)$arr[$i]["totalDays"]), 3);
			}
			
			return json_encode(array(
				"act" 		=> __METHOD__." ".__LINE__,
				"status" 	=> true,
				"result" 	=> $arr
			));
		}
		
		
		
		public function sendDataEntryById(){
			$getInfoById_arr = json_decode($this->getInfoById(), true);
			
			$this->idApartment = $getInfoById_arr["result"]["id_apartment"];
			$this->dateValue = $this->dateEntry;
			$getInfoByIdApartmentAndDates_arr = json_decode($this->getInfoByIdApartmentAndDates(), true);

			foreach($getInfoByIdApartmentAndDates_arr["result"] as $apartmentState_result){
				if($apartmentState_result["daysLeft"] > 0)
					return json_encode(array(
						"act" 		=> __CLASS__." -> ".__METHOD__." ".__LINE__,
						"status" 	=> false,
						"result" 	=> "Квартира еще сдается!"
					));
			}
			mysql_query("
				UPDATE tb_apartment_state
				SET
					number_of_adults 	= '".$this->numberOfAdults."',
					number_of_children 	= '".$this->numberOfChildren."',
					amount_in_cash 		= '".$this->amountInCash."',
					pledge 				= '".$this->pledge."',
					date_entry 			= '".$this->dateEntry."',
					id_employee 		= '".$this->idEmployee."'
				WHERE
					id 					= '".$this->id."'
					AND
					`delete` = 0
			") or die(mysql_error()." <b>".__FILE__." ".__LINE__."</b>");
			
			return json_encode(array(
				"act" 		=> __CLASS__." -> ".__METHOD__." ".__LINE__,
				"status" 	=> true,
				"result" 	=> true
			));
		}
		
		public function getInfoByIdAndDateEntry(){
			$query = mysql_query("
				SELECT *
				FROM tb_apartment_state
				WHERE 
					id 			= '".$this->id."'
					AND
					date_entry 	= '".$this->dateEntry."'
					AND
					`delete` = 0
			") or die(mysql_error()." <b>".__FILE__." ".__LINE__."</b>");
			
			$arr = mysql_fetch_array($query);
			return json_encode(array(
				"act" 		=> __CLASS__." -> ".__METHOD__." ".__LINE__,
				"status" 	=> true,
				"result" 	=> $arr
			));
		}
		
		public function getInfoByIdAndDateExit(){
			$query = mysql_query("
				SELECT *
				FROM tb_apartment_state
				WHERE 
					id 			= '".$this->id."'
					AND
					date_exit 	= '".$this->dateExit."'
					AND
					`delete` = 0
			") or die(mysql_error()." <b>".__FILE__." ".__LINE__."</b>");
			
			$arr = mysql_fetch_array($query);
			return json_encode(array(
				"act" 		=> __CLASS__." -> ".__METHOD__." ".__LINE__,
				"status" 	=> true,
				"result" 	=> $arr
			));
		}
		
		public function isExitByDateByIdEmployeeByIdApartment(){
				$query = mysql_query("
				SELECT id
				FROM tb_apartment_state
				WHERE 
					id_apartment 	= '".$this->idApartment."'
					AND
					date_exit 	= DATE('".$this->dateValue."')
					AND
					id_employee 	= '".$this->idEmployee."'
					AND
					`delete` = 0
			") or die(mysql_error()." <b>".__FILE__." ".__LINE__."</b>");
			
			$arr = array();
			for($i = 0; $i < mysql_num_rows($query); $i++){
				$arr[$i] = mysql_fetch_array($query);
			}
			
			return json_encode(array(
				"act" 		=> __CLASS__." -> ".__METHOD__." ".__LINE__,
				"status" 	=> true,
				"result" 	=> $arr
			));
		}
		
		public function isExitByDatePeriodByIdApartment(){
				$query = mysql_query("
				SELECT id
				FROM tb_apartment_state
				WHERE 
					id_apartment 	= '".$this->idApartment."'
					AND
					date_exit 	<= DATE('".$this->dateStart."')
					AND
					date_exit 	>= DATE('".$this->dateEnd."')
					AND
					`delete` = 0
			") or die(mysql_error()." <b>".__FILE__." ".__LINE__."</b>");
			
			$arr = array();
			for($i = 0; $i < mysql_num_rows($query); $i++){
				$arr[$i] = mysql_fetch_array($query);
			}
			
			return json_encode(array(
				"act" 		=> __CLASS__." -> ".__METHOD__." ".__LINE__,
				"status" 	=> true,
				"result" 	=> $arr
			));
		}
		
		public function isNotReadyByDateByIdApartment(){
				$query = mysql_query("
				SELECT id
				FROM tb_apartment_state
				WHERE 
					id_apartment 			= '".$this->idApartment."'
					AND
					date_exit 				= DATE('".$this->dateValue."')
					AND
					`apartment_is_ready` 	= 0
					AND
					`delete` 				= 0
			") or die(mysql_error()." <b>".__FILE__." ".__LINE__."</b>");
			
			$arr = array();
			for($i = 0; $i < mysql_num_rows($query); $i++){
				$arr[$i] = mysql_fetch_array($query);
			}
			
			return json_encode(array(
				"act" 		=> __CLASS__." -> ".__METHOD__." ".__LINE__,
				"status" 	=> true,
				"result" 	=> $arr
			));
		}
		
		public function getInfoByDate(){
			$query = mysql_query("
				SELECT *
				FROM tb_apartment_state
				WHERE 
					id 			= '".$this->id."'
					AND
					date_exit 	>= DATE('".$this->dateValue."')
					AND
					date_entry 	<= DATE('".$this->dateValue."')
					AND
					`delete` = 0
			") or die(mysql_error()." <b>".__FILE__." ".__LINE__."</b>");
			
			$arr = mysql_fetch_array($query);
			
			$this->dateEntry 	= $arr["date_entry"];
			$this->dateExit 	= $arr["date_exit"];
			$daysLed 			= json_decode($this->getCountDaysByPeriodDate(), true);
			
			$this->dateEntry	= $this->dateValue;
			$totalDays 			= json_decode($this->getCountDaysByPeriodDate(), true);
			
			
			
			return json_encode(array(
				"act" 		=> __CLASS__." -> ".__METHOD__." ".__LINE__,
				"status" 	=> true,
				"result" 	=> array(
					"daysLeft" 		=> $daysLed["result"],
					"totalDays" 	=> $totalDays["result"],
					"array" 		=> $arr
				)
			));
		}
		
		public function getCountDaysByPeriodDate(){
			//echo $this->dateEntry." ";
			//echo $this->dateExit." ";
			$dt1 = new DateTime($this->dateExit);
			$dt2 = new DateTime($this->dateEntry);
			$interval = date_diff($dt1,$dt2, true);
			$days = $interval->format('%a');
			//echo " = ".$days."<br>";
			return json_encode(array(
				"act" 		=> __CLASS__." -> ".__METHOD__." ".__LINE__,
				"status" 	=> true,
				"result" 	=> $days
			));
		}
		
		public function sendDataExitById(){
			$checkCorrectDate_arr = json_decode($this->checkCorrectDateExit(), true);
			if($checkCorrectDate_arr["status"] === false)
				return json_encode(array(
					"act" 		=> __CLASS__." -> ".__METHOD__." ".__LINE__,
					"status" 	=> false,
					"result" 	=> $checkCorrectDate_arr
				));
				
			mysql_query("
				UPDATE tb_apartment_state
				SET
					is_exit 					= '".$this->isExit."',
					bail_returned 				= '".$this->bailReturned."',
					deposit_can_be_transferred 	= '".$this->depositCanBeTransferred."',
					id_employee 				= '".$this->idEmployee."',
					date_exit 					= '".$this->dateExit."'
				WHERE
					id 			= '".$this->id."'
					AND
					`delete` = 0
			") or die(mysql_error()." <b>".__FILE__." ".__LINE__."</b>");
				
			return json_encode(array(
				"act" 		=> __CLASS__." -> ".__METHOD__." ".__LINE__,
				"status" 	=> true,
				"result" 	=> true
			));
		}
		
		public function sendReady(){
			mysql_query("
				UPDATE tb_apartment_state
				SET
					apartment_is_ready='".$this->apartmentIsReady."'
				WHERE
					id='".$this->id."'
					AND
					`delete` = 0
			") or die(mysql_error()." <b>".__FILE__." ".__LINE__."</b>");
			
			return json_encode(array(
				"act" 		=> __METHOD__." ".__LINE__,
				"status" 	=> true,
				"result" 	=> true
			));
		}
		
		private function checkCorrectDateExit(){
			$getInfoById_arr = json_decode($this->getInfoById(), true);
			//echo $this->id;
			//echo "<pre>";
			//var_dump($getInfoById_arr["result"]["date_entry"]);
			//echo "</pre>";$datetime1 = date_create($this->dateEntry);
			$datetime1 = date_create($getInfoById_arr["result"]["date_entry"]);
			$datetime2 = date_create($this->dateExit);
			$interval = date_diff($datetime1, $datetime2);
			//echo (int)$interval->format('%R%a');
			if((int)$interval->format('%R%a') < 0)
				return json_encode(array(
					"act" => __METHOD__." ".__LINE__,
					"status" => false,
					"result" => (int)$interval->format('%R%a')
				));
				
			return json_encode(array(
				"act" => __METHOD__." ".__LINE__,
				"status" => true,
				"result" => (int)$interval->format('%R%a')
			));
		}
		
		public function changeDateMoneyReceivedById(){
			$info = json_decode($this->getInfoById(), true);
			echo $info["date_money_received"];
			exit();
			mysql_query("
				UPDATE tb_apartment_state
				SET
					date_money_received='".time()."'
				WHERE
					id='".$this->id."'
					AND
					`delete` = 0
			") or die(mysql_error()." <b>".__FILE__." ".__LINE__."</b>");
			
			return json_encode(array(
				"act" 		=> __METHOD__." ".__LINE__,
				"status" 	=> true,
				"result" 	=> true
			));
		}
		
		public function updateAmountInCashSsReceived(){
			mysql_query("
				UPDATE tb_apartment_state
				SET
					`amount_in_cash_is_received` = '".(int)$this->amountInCashSsReceived."'
				WHERE
					id='".$this->id."'
			") or die(mysql_error()." <b>".__FILE__." ".__LINE__."</b>");
			
			return json_encode(array(
				"act" 		=> __METHOD__." ".__LINE__,
				"status" 	=> true,
				"result" 	=> true
			));
		}
	}
?>