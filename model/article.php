<?php

class Article{
        
        private ?int $articleID=null;
	    private ?string $titre=null ;
        private ?string $type=null ;
		private ?string $image=null ;
        private ?string $description=null ;
        private ?int $userID=null ;

        function __construct( string $titre, string $type,  string $image, string $description, int $userID){

            $this->titre=$titre;
            $this->type=$type;
            $this->image=$image;
            $this->description=$description;
            $this->userID=$userID;
            
        }

        function getArticleID(): int{
            return $this->articleID;
        }

        function getTitre(): string{
            return $this->titre;
        }

        function getType(): string{
            return $this->type;
        }
        
        function getImage(): string{
            return $this->image;
        }

        function getDescription(): string{
            return $this->description;
        }

        function setTitre(string $titre): void{
            $this->titre=$titre;
        }

        function setType(string $type): void{
            $this->type=$type;
        }

        function setImage(string $image): void{
            $this->image=$image;
        }

        function setDescription(string $description): void{
            $this->description=$description;
        }



}




?>