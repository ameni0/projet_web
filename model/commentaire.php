<?php

class Commentaire{
        private  $cID;
		private  $text;
		private  $userID;
		private  $articleID;

		function __construct($cID, $text, $userID, $articleID){
			
			$this->cID=$cID;
			$this->text=$text;
			$this->userID=$userID;
			$this->articleID=$articleID;


		}
		
		function getCID(){
			return $this->cID;
		}
		function getText():string{
			return $this->text;

        }
	    
        function setText(string $text):void{
			$this->text=$text;
		}



}

?>