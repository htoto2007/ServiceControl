<?php
	class TitlesGeneralsExpenses{
		public $id = 0;
		public $title = "";
		
		public function getInfo(){
			$arr = array();
			$query = mysql_query("
				SELECT *
				FROM tb_titles_generals_expenses
				WHERE `delete` = 0
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
				FROM tb_titles_generals_expenses
				WHERE 
					`delete` = 0
					AND
					id = '".$this->id."'
			") or die(mysql_error()." <b>".__FILE__." ".__LINE__."</b>");
			
			$arr = mysql_fetch_array($query);
			
			return json_encode(array(
				"act" 		=> __METHOD__." ".__LINE__,
				"status" 	=> true,
				"result" 	=> $arr
			));
		}
		
		public function deleteById(){
			mysql_query("
				UPDATE tb_titles_generals_expenses
				SET `delete` = 1
				WHERE `id` = '".$this->id."'
			") or die(mysql_error()." <b>".__FILE__." ".__LINE__."</b>");
			
			return json_encode(array(
				"act" 		=> __METHOD__." ".__LINE__,
				"status" 	=> true,
				"result" 	=> ""
			));
		}
		
		public function send(){
			if($this->title == "")
				return json_encode(array(
					"act" 		=> __METHOD__." ".__LINE__,
					"status" 	=> false,
					"result" 	=> ""
				));
			
			mysql_query("
				INSERT INTO tb_titles_generals_expenses
				SET title = '".$this->title."'
			") or die(mysql_error()." <b>".__FILE__." ".__LINE__."</b>");
			
			return json_encode(array(
				"act" 		=> __METHOD__." ".__LINE__,
				"status" 	=> true,
				"result" 	=> ""
			));
		}
	}
?>