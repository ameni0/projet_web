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

    public function modifierRating($rating, $articleID, $userID){
        $db = config::getConnexion();
    
        // Check if a rating for this article and user already exists
        $existingRating = $this->getRatingByArticleAndUser($articleID, $userID);
    
        if ($existingRating) {
            // Update the existing rating
            $sql = "UPDATE rating SET note=:note where articleID=:articleID and userID=:userID";
        } else {
            // Create a new rating
            $sql = "INSERT INTO rating (note, articleID, userID) VALUES (:note, :articleID, :userID)";
        }
    
        try {
            $query = $db->prepare($sql);
            $query->execute([
                'note' => $rating,
                'articleID' => $articleID,
                'userID' => $userID
            ]);
        } catch (PDOException $e) {
            $e->getMessage();
        }
    }
    
    // Function to check if a rating already exists for the given article and user
    public function getRatingByArticleAndUser($articleID, $userID) {
        $db = config::getConnexion();
        $sql = "SELECT * FROM rating WHERE articleID = :articleID AND userID = :userID LIMIT 1";
    
        try {
            $query = $db->prepare($sql);
            $query->execute([
                'articleID' => $articleID,
                'userID' => $userID
            ]);
    
            return $query->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $e->getMessage();
            return false;
        }
    }
    
    
}

?>