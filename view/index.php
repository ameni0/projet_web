<?php
include_once '../controller/userC.php';
include_once '../controller/articleC.php';
include_once '../controller/commentaireC.php';
session_start();

$userC=new userC();
$articleC=new articleC();
$commentaireC=new commentaireC();

if(isset($_POST['logout'])){
    
    $userC->logout();
    header('location:login.php');
}

if(isset($_POST['addA'])){
    header('location:addArticle.php');
}

if(isset($_POST['commenter'])){
    $comment= new commentaire($_POST['comment'], $_POST['articleID'], $_SESSION['userID']);
    $commentaireC->addCommentaire($comment, $_POST['articleID'], $_SESSION['userID']);
}


$articles = $articleC->afficher();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/stylesheet.css">
    <title>Articles</title>
    
</head>
<body>

<div class="navbar">
    <?php if (isset($_SESSION['username'])) {?>
    <a href="logout.php" class="title" style="float: right;">Logout</a>
    <a href="profile.php" style="float: right;">Profile</a>
    <?php } ?>
    <a href="index.php" class="title">Home Page</a>
    <?php if (!isset($_SESSION['username'])) {?>
    <a href="login.php" class="title" style="float: right;">Login</a>
    <?php } ?>
    <a href="addArticle.php" class="title" style="float: right;">Add Article</a>
    
    
</div>

<h2 class="title">All Articles</h2>
<ul class="article-list">
    <?php foreach ($articles as $article) { ?>
        <li class="article-item">
            <h3><?php echo $article['titre']; ?></h3>
            <img src="<?php echo $article['image']; ?>" width="150" height="150">
            <p>Type: <?php echo $article['type']; ?></p>
            <p>Description: <?php echo $article['description']; ?></p>
           
            <!-- Display the article's comments -->
            <div class="comments-section">
                <h4>Comments:</h4>
                <div class="comments-container">
                    <?php
                    // Fetch comments for the current article from the database
                    $comments = $commentaireC->afficher($article['articleID']);

                    if (!empty($comments)) {
                        foreach ($comments as $c) {
                             $name = $userC->getUsernameById($c['userID']);
                            echo "<div class='comment'>";
                            echo "<p><strong>{$name}:</strong> {$c['text']}</p>";
                            echo "</div>";
                        }
                    } else {
                        echo "<p>No comments yet.</p>";
                    }
                    ?>
                </div>
            </div>
            <form  method="post">
                <input type="hidden" name="articleID" value="<?php echo $article['articleID']; ?>">
                <textarea name="comment" rows="4" cols="40" placeholder="Write a comment" style="resize: none;"></textarea><br>
                <button type="submit" name="commenter">Submit Comment</button>
            </form>

        </li>
    <?php } ?>
</ul>


</body>
</html>