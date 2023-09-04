<?php
include_once '../config.php';
require_once '../model/article.php';

class articleC{

    public function afficher() {
        $db=config::getConnexion();
        try {
            $query=$db->prepare("SELECT * FROM article");
            $query->execute();
            $result=$query->fetchAll();
            return $result;
        }catch(PDOException $e){
            $e->getMessage();
        }
    }

    public function supprimer($id){
        $sql="DELETE FROM article WHERE articleID=:id";
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
        $sql = "SELECT * FROM article WHERE articleID =$id";
        $db=config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute();

            $article=$query->fetch();
            return $article;
        }catch(PDOException $e){
            $e->getMessage();
        }
    }
    public function addArticle ($article,$image,$userID){

        $pdo =config::getConnexion ();
        try{    
            $query =$pdo->prepare(
         "INSERT INTO article (titre, type, image, description, userID) 
        VALUES(:titre, :type, :image, :description, :userID)");
       
       $query ->execute([
        'titre'=>$article->getTitre(),
        'type'=>$article->getType(),
        'image'=>$image,
        'description'=>$article->getDescription(),
        'userID'=>$userID
    ]);
    
    } catch (PDOException $e)
    {
     $e ->getMessage();
    }
    }

    function upload_image($path, $file){
        $targetDir = $path;
    
        // get the filename
        $filename = basename($file['name']);
        $targetFilePath = $targetDir . $filename;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
    
        If(!empty($filename)){
            // allow certain file format
            $allowType = array('jpg', 'png', 'jpeg', 'gif', 'pdf');
            if(in_array($fileType, $allowType)){
                // upload file to the server
                if(move_uploaded_file($file['tmp_name'], $targetFilePath)){
                    return $targetFilePath;
                }
            }
        }
    
        return $path . $filename;
    }

    public function modifierArticle($article,$image,$id){
        $sql="UPDATE article SET titre=:titre, type=:type, image=:image, description=:description WHERE articleID=:id";
        $db = config::getConnexion();
        try{
            $query=$db->prepare($sql);
            $query->execute([
                'titre'=>$article->getTitre(),
                'type'=>$article->getType(),
                'image'=>$image,
                'description'=>$article->getDescription(),
                'id'=>$id

            ]);
        }
        catch (PDOException $e){
            $e->getMessage();
        }
    }


    public function search($search ,$search_value)
	{
		$sql=" SELECT * FROM article where '.$search.' like '%$search_value%' ";

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
                'SELECT * FROM article ORDER BY '.$tri.' ASC'
            );
            $query->execute();
            return $query->fetchAll();
        } catch (PDOException $e) {
            $e->getMessage();
        }
    }

    function getArticlesByUserID($userID) {
        $db = config::getConnexion();
        try {
            $query = $db->prepare(
                'SELECT * FROM article WHERE userID = :userID'
            );
            $query->execute([
                'userID' => $userID
            ]);
            return $query->fetchAll();
        } catch (PDOException $e) {
            $e->getMessage();
        }
    }
}

?>