<?php
    
    session_start();
    include_once '../controller/userC.php';

    if(isset($_SESSION['username'])){
        header("Location: index.php");
    }
   
    if (isset($_POST["username"]) && isset($_POST["password"])) {
        if (!empty($_POST["username"])&& !empty($_POST["password"])){
            $username=$_POST["username"];
            $password=$_POST["password"];
            $userC = new UserC();
            $login=$userC->login($username,$password);

            if($login!=null){
                
                $_SESSION['userID']=$login->userID;
                $_SESSION['username']=$username;
                $_SESSION['password']=$password;
                $_SESSION['role']=$login->role;

                header("Location: index.php");
                
            }else{
                $error="Username or password incorrect";
            }
            
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>
    <form  method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br>

        <button type="submit">Login</button>
    </form>
</body>
</html>
