<?php
	class Apartment{
		private $arr = array();
		public $adres = "";
		public $id = "";
		public $sortable = 0;
		
		public function getInfo(){
			$query = mysql_query("
				SELECT *
				FROM tb_apartment
				WHERE `delete` = 0
				ORDER BY sort
			") or die(mysql_error()." <b>".__FILE__." ".__LINE__."</b>");
			
			for($i = 0; $i < mysql_num_rows($query); $i++)
				$this->arr[$i] = mysql_fetch_array($query);
			
			return json_encode(array(
				"act" => __METHOD__." ".__LINE__,
				"status" => true,
				"result" => $this->arr
			));
		}
		
		public function getInfoById(){
			$query = mysql_query("
				SELECT *
				FROM tb_apartment
				WHERE 
					id='".$this->id."'
					AND
					`delete` = 0
				ORDER BY id DESC
			") or die(mysql_error()." <b>".__FILE__." ".__LINE__."</b>");
			
			$arr = mysql_fetch_array($query);
			
			return json_encode(array(
				"act" => __CLASS__." -> ".__METHOD__." ".__LINE__,
				"status" => true,
				"result" => $arr
			));
		}
		
		public function add(){
			$arrResult = json_decode($this->checkDataPreAdd(), true);
			if($arrResult["status"] == false)
				return json_encode(array(
					"act" => __CLASS__." -> ".__METHOD__." ".__LINE__,
					"status" => false,
					"result" => $arrResult
				));
			
			$query = mysql_query("
				INSERT INTO tb_apartment
				SET 
					adres='".$this->adres."'
			") or die(mysql_error()." <b>".__FILE__." ".__LINE__."</b>");
			
			$this->id = mysql_insert_id();
			
			return json_encode(array(
				"act" => __CLASS__." -> ".__METHOD__." ".__LINE__,
				"status" => true,
				"result" => $this->id
			));
		}
		
		private function checkDataPreAdd(){
			if($this->adres == "")
				return json_encode(array(
					"act" => __CLASS__." -> ".__METHOD__." ".__LINE__,
					"status" => false,
					"result" => "empty"
				));
			//$len = 10;
			if(strlen($this->adres) < ($len = 10))
				return json_encode(array(
					"act" => __CLASS__." -> ".__METHOD__." ".__LINE__,
					"status" => false,
					"result" => "length < ".$len
				));
			
			return json_encode(array(
				"act" => __CLASS__." -> ".__METHOD__." ".__LINE__,
				"status" => true,
				"result" => true
			));
		}
		
		public function deleteById(){
			mysql_query("
				UPDATE tb_apartment
				SET `delete` = 1
				WHERE id = '".$this->id."'
			") or die(mysql_error()." <b>".__FILE__." ".__LINE__."</b>");
			
			return json_encode(array(
				"act" => __CLASS__." -> ".__METHOD__." ".__LINE__,
				"status" => true,
				"result" => ""
			));
		}
		
		public function changeSort(){
			mysql_query("
				UPDATE tb_apartment
				SET `sort` = `sort` + ".$this->sortable."
				WHERE id = '".$this->id."'
			") or die(mysql_error()." <b>".__FILE__." ".__LINE__."</b>");
			
			return json_encode(array(
				"act" => __CLASS__." -> ".__METHOD__." ".__LINE__,
				"status" => true,
				"result" => ""
			));
		}
	}
?>