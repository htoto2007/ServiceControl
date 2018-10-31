<?php
	class PrivateExpenses{
		public $comment = "";
		public $price = 0;
		public $idEmployee = 0;
		public $idApartment = 0;
		
		public function create(){
			$arr = $this->checkData();
			$arr = json_decode($arr, true);
			if($arr["status"] === false){
				return json_encode(array(
					"act" => __METHOD__." ".__LINE__,
					"status" => false,
					"result" => $arr
				));
			}
			
			mysql_query("
				INSERT INTO tb_private_expenses
				SET
					comment='".$this->comment."',
					price='".$this->price."',
					id_employee='".$this->idEmployee."',
					id_apartment='".$this->idApartment."'
			") or die(mysql_error()." <b>".__FILE__." ".__LINE__."</b>");
			
			return json_encode(array(
				"act" => __METHOD__." ".__LINE__,
				"status" => true,
				"result" => true
			));
		}
		
		public function getInfoByIdApartment(){
			$arr = array();
			
			$query = mysql_query("
				SELECT *
				FROM tb_private_expenses
				WHERE id_apartment='".$this->idApartment."'
				ORDER BY id DESC
			") or die(mysql_error()." <b>".__FILE__." ".__LINE__."</b>");
			
			for($i = 0; $i < mysql_num_rows($query); $i++)
				$arr[$i] = mysql_fetch_array($query);
			
			return json_encode(array(
				"act" => __METHOD__." ".__LINE__,
				"status" => true,
				"result" => $arr
			));
		}
		
		private function checkData(){
			if(($this->comment == "") ||
				($this->price == "") ||
				($this->idApartment == "") ||
				($this->idEmployee == "") ) 
				return json_encode(array(
					"act" => __METHOD__." ".__LINE__,
					"status" => false,
					"result" => "empty"
				));
			
			return json_encode(array(
				"act" => __METHOD__." ".__LINE__,
				"status" => true,
				"result" => true
			));
		}
	}
?>