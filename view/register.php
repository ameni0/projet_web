<?php
    session_start();
    include_once '../controller/userC.php';

    if(isset($_SESSION['username'])){
        header("Location: login.php");
    }
   
    if (isset($_POST["username"]) && isset($_POST["password"]) && isset($_POST["confirm-password"])) {
        if (!empty($_POST["username"])&& !empty($_POST["password"]) && isset($_POST["confirm-password"])){
            $user=new user(
                $_POST['username'],
                $_POST['password']
                );
            $userC = new UserC();

            if($userC->verif($_POST["username"])==null){
                
                $userC->register($user);

                header("Location: login.php");
                
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
    <title>Register</title>
</head>
<body>
    <h1>Register</h1>
    <form method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br>

        <label for="confirm-password">Confirm Password:</label>
        <input type="password" id="confirm-password" name="confirm-password" required><br>

        <button type="submit">Register</button>
    </form>
</body>
</html>
