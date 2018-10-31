<?php
	class Counters{
		public $idApartment = "";
		public $idEmployee = "";
		public $gasPrice = "";
		public $gasPaid = false;
		public $shineReadings = "";
		public $shinePrice = "";
		public $shinePaid = false;
		public $waterReadings = "";
		public $waterPrice = "";
		public $waterPaid = false;
		public $communalPrice = "";
		public $communalPaid = false;
		
		public function sendData(){
			$arrResult = json_decode($this->checkEmptyField(), true);
			if($arrResult["status"] === true){
				mysql_query("
					INSERT INTO tb_counters
					SET
						id_apartment='".$this->idApartment."',
						id_employee='".$this->idEmployee."',
						gas_price='".$this->gasPrice."',
						gas_paid='".$this->gasPaid."',
						shine_readings='".$this->shineReadings."',
						shine_price='".$this->shinePrice."',
						shine_paid='".$this->shinePaid."',
						water_readings='".$this->waterReadings."',
						water_price='".$this->waterPrice."',
						water_paid='".$this->waterPaid."',
						communal_price='".$this->communalPrice."',
						communal_paid='".$this->communalPaid."'
				") or die(mysql_error()." <b>".__FILE__." ".__LINE__."</b>");
				
				return json_encode(array(
					"act" => __CLASS__." -> ".__METHOD__." ".__LINE__,
					"status" => true,
					"result" => true
				));
			} else {
				return json_encode(array(
					"act" => __CLASS__." -> ".__METHOD__." ".__LINE__,
					"status" => false,
					"result" => $arrResult
				));
			}
		}
		
		public function getInfoByIdApartment(){
			$arr = array();
			$query = mysql_query("
				SELECT *
				FROM tb_counters
				WHERE id_apartment='".$this->idApartment."'
				ORDER BY id DESC
			") or die(mysql_error()." <b>".__FILE__." ".__LINE__."</b>");
			
			for($i = 0; $i < mysql_num_rows($query); $i++)
				$arr[$i] = mysql_fetch_array($query);
				
			return json_encode(array(
				"act" => __CLASS__." -> ".__METHOD__." ".__LINE__,
				"status" => true,
				"result" => $arr
			));
		}
		
		public function checkEmptyField(){
			if((!$this->idApartment) ||
			(!$this->idEmployee) ||
			(!$this->gasPrice) ||
			//(!$this->gasPaid) ||
			(!$this->shineReadings) ||
			(!$this->shinePrice) ||
			//(!$this->shinePaid) ||
			(!$this->waterReadings) ||
			(!$this->waterPrice) ||
			//(!$this->waterPaid) ||
			(!$this->communalPrice) ){
			//(!$this->communalPaid) ){
				return json_encode(array(
					"act" => __CLASS__." -> ".__METHOD__." ".__LINE__,
					"status" => false,
					"result" => "is empty!"
				));
			}
			return json_encode(array(
				"act" => __CLASS__." -> ".__METHOD__." ".__LINE__,
				"status" => true,
				"result" => true
			));
		}
	}
?>