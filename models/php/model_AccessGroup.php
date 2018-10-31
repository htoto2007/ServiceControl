<?php
	class AccessGroup{
		private $arr 	= array();
		public 	$id 	= 0;
		
		public function getInfo(){
			$query = mysql_query("
				SELECT *
				FROM tb_access_group
			") or die(mysql_error()." <b>".__FILE__." ".__LINE__."</b>");
			
			for($i = 0; $i < mysql_num_rows($query); $i++)
				$this->arr[$i] = mysql_fetch_array($query);
			
			return json_encode(array(
				"act" 		=> __METHOD__." ".__LINE__,
				"status" 	=> true,
				"result" 	=> $this->arr
			));
		}
		
		public function getRankById(){
			$arr = array();
			$query = mysql_query("
				SELECT *
				FROM tb_access_group
				WHERE id = '".$this->id."'
			") or die(mysql_error()." <b>".__FILE__." ".__LINE__."</b>");
			
			$arr = mysql_fetch_array($query);
			
			return json_encode(array(
				"act" => __METHOD__." ".__LINE__,
				"status" => true,
				"result" => $arr
			));
		}
	}
?>