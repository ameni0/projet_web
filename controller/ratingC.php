<?php
include_once '../config.php';
require_once '../model/rating.php';

class ratingC{

    public function addRating($rating, $articleID, $userID) {
        $pdo = config::getConnexion();
        try {
            $query = $pdo->prepare("INSERT INTO rating (note, articleID, userID) VALUES (:note, :articleID, :userID)");
            $query->execute([
                'note' => $rating->getNote(),
                'articleID' => $articleID,
                'userID' => $userID
            ]);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage(); // Handle the error properly
        }
    }
    

    public function getNote($articleID,$userID){
        $db=config::getConnexion();
        try {
            $query=$db->prepare("SELECT note FROM rating where articleID=$articleID and userID=$userID");
            $query->execute();
            $result=$query->fetchAll();
            
            if($result==null){
                return 0;
            }
            
            else{
                return $result[0]['note'];
            }

        }catch(PDOException $e){
            $e->getMessage();
        }
    }

    public function getId($articleID,$userID){
        $db=config::getConnexion();
        try {
            $query=$db->prepare("SELECT id FROM rating where articleID=$articleID and userID=$userID");
            $query->execute();
            $result=$query->fetchAll();
            
            if($result==null){
                return 0;
            }
            
            else{
                return $result[0]['id'];
            }

        }catch(PDOException $e){
            $e->getMessage();
        }
    }

    public function modifierRating($rating, $id, $articleID, $userID){
        $sql="UPDATE rating SET note=:note WHERE id=:id AND articleID=$articleID AND userID=:userID";
        $db = config::getConnexion();
        try{
            $query=$db->prepare($sql);
            $query->execute([
                'note'=>$rating, 
                'id'=>$id,
                'articleID'=>$articleID,
                'userID'=>$userID
            ]);
        }
        catch (PDOException $e){
            $e->getMessage();
        }
    }
    
}

?>