<?php
	class GeneralsExpenses{
		public $id = 0;
		public $comment = "";
		public $price = 0;
		public $idEmployee = 0;
		public $startDate = 0;
		public $endDate = 0;
		public $dateValue = 0;
		public $intervalDay = 0; 
		public $arrApartments = array();
		public $idApartment = 0;
		public $idTitlesGeneralsExpenses = 0;
		
		public function create(){
			$checkCorrectDate_arr = json_decode($this->checkCorrectDate(), true);
			if($checkCorrectDate_arr["status"] === false)
				return json_encode(array(
					"act" 		=> __METHOD__." ".__LINE__,
					"status" 	=> false,
					"result" 	=> $checkCorrectDate_arr
				));
			
			$dateIntersection_arr = json_decode($this->dateIntersection(), true);
			if($dateIntersection_arr["status"] === false)
				return json_encode(array(
					"act" 		=> __METHOD__." ".__LINE__,
					"status" 	=> false,
					"result" 	=> $dateIntersection_arr
				));
				
			if(($this->price == "") || ($this->price == 0))
				return json_encode(array(
					"act" 		=> __METHOD__." ".__LINE__,
					"status" 	=> false,
					"result" 	=> $this->price
				));
				
			if(($this->idTitlesGeneralsExpenses == "") || ($this->idTitlesGeneralsExpenses == 0))
				return json_encode(array(
					"act" 		=> __METHOD__." ".__LINE__,
					"status" 	=> false,
					"result" 	=> $this->idTitlesGeneralsExpenses
				));
				
			/*echo "<pre><div style='text-align: left; font-size: 10pt; color: #000;'>";
			var_dump($this->arrApartments);
			echo $this->endDate;
			echo "</div></pre>";
			exit();*/
			mysql_query("
				INSERT INTO tb_generals_expenses
				SET
					id_titles_generals_expenses = '".$this->idTitlesGeneralsExpenses."',
					arr_apartments = '".json_encode($this->arrApartments)."',
					price = '".$this->price."',
					id_employee = '".$this->idEmployee."',
					start_date = '".$this->startDate."',
					end_date = '".$this->endDate."'
			") or die(mysql_error()." <b>".__FILE__." ".__LINE__."</b>");
			
			return json_encode(array(
				"act" 		=> __METHOD__." ".__LINE__,
				"status" 	=> true,
				"result" 	=> true
			));
		}
		
		public function getInfoByDateAndIdTitleGeneralsExpensesAndIdApartment(){
			$arrRow = array();
			$arr = array();
			//$this->checkCorrectDate();
			$query = mysql_query("
				SELECT *
				FROM tb_generals_expenses
				WHERE 
					id_titles_generals_expenses = '".$this->idTitlesGeneralsExpenses."'
					AND
					start_date <= DATE('".$this->dateValue."')
					AND
					end_date >= DATE('".$this->dateValue."')
			") or die(mysql_error()." <b>".__FILE__." ".__LINE__."</b>");
			
			for($i = 0; $i < mysql_num_rows($query); $i++){
				$arrRow = mysql_fetch_array($query);
				$apartments = json_decode($arrRow["arr_apartments"], true);
				/*echo "<pre>";
				var_dump($arr);
				echo "</pre>";*/
				foreach($apartments as $generalsExpensesApartment){
					//echo $generalsExpensesApartment["id"]." == ";
					//echo $this->idApartment." ";
					if((int)$generalsExpensesApartment["id"] === (int)$this->idApartment){
						//echo " true<br>";
						$arr[$i] = $arrRow;
						break;
					}
				}
				
				/*echo "<pre>";
				var_dump($apartments);
				echo "</pre>";*/
				
			}
			
			return json_encode(array(
					"act" => __METHOD__." ".__LINE__,
					"status" => true,
					"result" => $arr
				));
			
			
		}
		
		public function getInfoByDateAndIdTitleGeneralsExpenses(){
			$arr = array();
			//$this->checkCorrectDate();
			$query = mysql_query("
				SELECT *
				FROM tb_generals_expenses
				WHERE 
					id_titles_generals_expenses = '".$this->idTitlesGeneralsExpenses."'
					AND
					start_date <= DATE('".$this->dateValue."')
					AND
					end_date >= DATE('".$this->dateValue."')
			") or die(mysql_error()." <b>".__FILE__." ".__LINE__."</b>");

			$arr = mysql_fetch_array($query);
				
			return json_encode(array(
				"act" => __METHOD__." ".__LINE__,
				"status" => true,
				"result" => arr
			));
		}
		
		public function dateIntersection(){
			$this->dateValue = $this->startDate;
			$getInfoByDateAndIdTitleGeneralsExpenses_arr = json_decode($this->getInfoByDateAndIdTitleGeneralsExpenses(), true);
			
			if(isset($getInfoByDateAndIdTitleGeneralsExpenses_arr["result"]["id"]))
				$apartmentIntersection_arr = json_decode($this->apartmentIntersection(), true);
				if($apartmentIntersection_arr["status"] === false){
					return json_encode(array(
						"act" 		=> __METHOD__." ".__LINE__,
						"status" 	=> false,
						"result" 	=> "Date already defined"
					));
				}
			
			$this->dateValue = $this->endDate;
			$getInfoByDateAndIdTitleGeneralsExpenses_arr = json_decode($this->getInfoByDateAndIdTitleGeneralsExpenses(), true);
			if(isset($getInfoByDateAndIdTitleGeneralsExpenses_arr["result"]["id"]))
				$apartmentIntersection_arr = json_decode($this->apartmentIntersection(), true);
				/*echo "<pre>";
				var_dump($apartmentIntersection_arr["status"]);
				echo "</pre>";
				exit;*/
				if($apartmentIntersection_arr["status"] === false){
					return json_encode(array(
						"act" 		=> __METHOD__." ".__LINE__,
						"status" 	=> false,
						"result" 	=> "Date already defined"
					));
				}
			
			return json_encode(array(
				"act" 		=> __METHOD__." ".__LINE__,
				"status" 	=> true,
				"result" 	=> ""
			));
		}
		
		public function apartmentIntersection(){
			$getInfoByDateAndIdTitleGeneralsExpenses_arr = json_decode($this->getInfoByDateAndIdTitleGeneralsExpenses(), true);
			$apartments_arr = json_decode($getInfoByDateAndIdTitleGeneralsExpenses_arr["result"]["arr_apartments"], true);
			/*echo "<pre>";
			var_dump($this->arrApartments);
			echo "</pre>";*/
			if(count($apartments_arr) < 1)
				return json_encode(array(
					"act" 		=> __METHOD__." ".__LINE__,
					"status" 	=> true,
					"result" 	=> ""
				));
				
			if(count($this->arrApartments) < 1)
				return json_encode(array(
					"act" 		=> __METHOD__." ".__LINE__,
					"status" 	=> true,
					"result" 	=> ""
				));
			
			foreach($apartments_arr as $generalsExpensesApartment){
				foreach($this->arrApartments as $apartment){
					//echo $generalsExpensesApartment["id"]." === ".$apartment["id"]."<br>";
					if((int)$generalsExpensesApartment["id"] === (int)$apartment["id"]){
						return json_encode(array(
							"act" 		=> __METHOD__." ".__LINE__,
							"status" 	=> false,
							"result" 	=> $generalsExpensesApartment["id"]." === ".$apartment["id"]
						));
					}
				}
			}
			
			return json_encode(array(
				"act" 		=> __METHOD__." ".__LINE__,
				"status" 	=> true,
				"result" 	=> ""
			));
		}
		
		public function getInfo(){
			$arr = array();
			
			$query = mysql_query("
				SELECT *
				FROM tb_generals_expenses
			") or die(mysql_error()." <b>".__FILE__." ".__LINE__."</b>");
			
			for($i = 0; $i < mysql_num_rows($query); $i++)
				$arr[$i] = mysql_fetch_array($query);
			
			return json_encode(array(
				"act" => __METHOD__." ".__LINE__,
				"status" => true,
				"result" => $arr
			));
		}
		
		private function checkCorrectDate(){
			//echo $this->endDate;
			if(($this->startDate === "") || ($this->endDate === ""))
				return json_encode(array(
					"act" => __METHOD__." ".__LINE__,
					"status" => false,
					"result" => "Date id empty"
				));
			$datetime1 = date_create($this->startDate);
			$datetime2 = date_create($this->endDate);
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
		
		public function deleteById(){
			mysql_query("
				DELETE FROM tb_generals_expenses 
				WHERE id = '".$this->id."'
			") or die(mysql_error()." <b>".__FILE__." ".__LINE__."</b>");
			
			return json_encode(array(
				"act" => __METHOD__." ".__LINE__,
				"status" => true,
				"result" => null
			));
		}
	}
?>