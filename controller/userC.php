<?php
include_once '../config.php';
require_once '../model/user.php';

class userC{

    public function afficher() {
        $db=config::getConnexion();
        try {
            $query=$db->prepare("SELECT * FROM user");
            $query->execute();
            $result=$query->fetchAll();
            return $result;

        }catch(PDOException $e){
            $e->getMessage();
        }
    }

    public function supprimer($id){
        $sql="DELETE FROM user WHERE userID=:id";
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
        $sql = "SELECT * FROM user WHERE userID =$id";
        $db=config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute();

            $user=$query->fetch();
            return $user;
        }catch(PDOException $e){
            $e->getMessage();
        }
    }
    
    public function register ($user){

        $pdo =config::getConnexion ();
        try{    
            $query =$pdo->prepare(
         "INSERT INTO user (username, password,role) 
        VALUES(:username,:password,:role)");
       
       $query ->execute([
        'username'=>$user->getUsername(),
        'password'=>$user->getPassword(),
        'role'=>$user->getRole()
    ]);
    
    } catch (PDOException $e)
    {
     $e ->getMessage();
    }
    }

    function modifierUtilisateur($user, $id){
        try {
            $db = config::getConnexion();
            $query = $db->prepare(
                'UPDATE user SET 
                    username = :username, 
                    password = :password
                WHERE userID = :id'
            );
            $query->execute([
                'username' => $user->getUsername(),
                'password' => $user->getPassword(),
                'id' => $id
            ]);
            echo $query->rowCount() . " records UPDATED successfully <br>";
        } catch (PDOException $e) {
            $e->getMessage();
        }
    }
    function recupererclient($id){
        $sql="SELECT * from user where userID=$id";
        $db = config::getConnexion();
        try{
            $query=$db->prepare($sql);
            $query->execute();

            $ad=$query->fetch();
            return $ad;
        }
        catch (Exception $e){
            die('Erreur: '.$e->getMessage());
        }
    }

    function login($username,$password)
		{
			$db = config::getConnexion();
			$sql = "SELECT * FROM user WHERE username='" . $username . "'and password= '". $password." ' " ;
			try
			{
				$query=$db->prepare($sql);
				$query->execute();
				$count=$query->rowCount();
				$result = $query->fetch(PDO::FETCH_OBJ);
				if($count==0)
				{
					$message="pseudo ou le mot de passe est incorrect";
				}
				else
				{
					$x=$query->fetch();
					$message=$x['username'];
					$_SESSION['username'] = $result->username ;
					$_SESSION['id'] = $result->userID ;
                    $_SESSION['role'] = $result->role ;
					echo "$message";

				}
				

			}
			catch (Exception $e)
				{
					$message= " ".$e->getMessage();
				}

			return $message;
		}

    function logout(){
        session_start();
        session_destroy();
        header('location:../view/login.php');
    }

}


 

?>

