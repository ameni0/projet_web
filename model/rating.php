<?php
class rating{
		private  $id;
		private  $note;
		private  $userID;

		function __construct($id, $note, $userID){
			
			$this->id=$id;
			$this->note=$note;
			$this->userID=$userID;

		}
		
		function getid(){
			return $this->id;
		}
		function getNote():string{
			return $this->note;

        }
	function setNote(string $note):void{
			$this->note=$note;
		}

    }
	
?>