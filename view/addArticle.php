<?php

include_once '../controller/articleC.php';
session_start();

if(isset($_POST['submit'])){
    
    $image = $_FILES['image'];

    $userID = $_SESSION['userID'];

    $articleC = new articleC();
    $path=$articleC->upload_image('../assets/articles/', $image);
    
    $article = new Article(
        $_POST['titre'],
        $_POST['type'],
        $path,
        $_POST['description'],
        $userID
    );
    $articleC->addArticle($article, $path, $userID);

    header('location:index.php');
}




?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Article</title>
</head>
<body>
    <h1>Add Article</h1>
    <form  method="post" enctype="multipart/form-data">
        <label for="titre">Title:</label>
        <input type="text" id="titre" name="titre" required><br><br>

        <label for="type">Type:</label>
        <select id="type" name="type" required>
            <option value="bouk">Bouk</option>
            <option value="omek">Omek</option>
        </select><br>

        <label for="description">Description:</label>
        <textarea id="description" name="description" rows="4" cols="50" required></textarea><br><br>

        <label for="image">Image:</label>
        <input type="file" id="image" name="image" accept="image/*" required><br><br>

        <input type="submit" name="submit" value="Add Article">
    </form>
</body>
</html>
