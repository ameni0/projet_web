<?php
include_once '../config.php';
require_once '../model/commentaire.php';

class commentaireC{

    public function afficher($articleID) {
        $db=config::getConnexion();
        try {
            $query=$db->prepare("SELECT * FROM commentaire where articleID=$articleID");
            $query->execute();
            $result=$query->fetchAll();
            return $result;
        }catch(PDOException $e){
            $e->getMessage();
        }
    }

    public function supprimer($id){
        $sql="DELETE FROM commentaire WHERE commentaireID=:id";
        $db=config::getConnexion();
        $query=$db->prepare($sql);
        $query->bindValue(':id',$id);
        try{
            $query->execute();
        }catch(PDOException $e){
            $e->getMessage();
        }
    }

    public function detail($id){
        $sql = "SELECT * FROM commentaire WHERE commentaireID =$id";
        $db=config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute();

            $commentaire=$query->fetch();
            return $commentaire;
        }catch(PDOException $e){
            $e->getMessage();
        }
    }
    public function addCommentaire ($commentaire,$articleID,$userID){

        $pdo =config::getConnexion ();
        try{    
            $query =$pdo->prepare(
         "INSERT INTO commentaire (text, articleID, userID) 
        VALUES(:text, $articleID, $userID)");
       
       $query ->execute([
        'text'=>$commentaire->getText()
    ]);
    
    } catch (PDOException $e)
    {
     $e ->getMessage();
    }
    }

    public function modifiercommentaire($commentaire, $id, $userID){
        $sql="UPDATE commentaire SET text=:text WHERE commentaireID=:id AND userID=:userID";
        $db = config::getConnexion();
        try{
            $query=$db->prepare($sql);
            $query->execute([
                'text'=>$commentaire->getText(),
                'id'=>$id,
                'userID'=>$userID
            ]);
        }
        catch (PDOException $e){
            $e->getMessage();
        }
    }


    public function search($search ,$search_value)
	{
		$sql=" SELECT * FROM commentaire where '.$search.' like '%$search_value%' ";

		$db =config::getConnexion();

		try{
			$result=$db->query($sql);

			return $result;

		}
		catch (Exception $e){
			die('Erreur: '.$e->getMessage());
		}
	}


    public function tri($tri) {
        try {
            $db = config::getConnexion();
            $query = $db->prepare(
                'SELECT * FROM commentaire ORDER BY '.$tri.' ASC'
            );
            $query->execute();
            return $query->fetchAll();
        } catch (PDOException $e) {
            $e->getMessage();
        }
    }
}

?>