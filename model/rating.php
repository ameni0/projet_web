<?php
class rating{
		private  $id;
		private  $note;
		private  $articleID;
		private  $userID;

		function __construct($id, $note){
			
			$this->id=$id;
			$this->note=$note;

		}
		
		function getid(){
			return $this->id;
		}
		function getNote():int{
			return $this->note;

        }
	function setNote(int $note):void{
			$this->note=$note;
		}

    }
	
?>