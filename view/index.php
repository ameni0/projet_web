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
    <title>Articles</title>
    <style>
        /* Add CSS styles here */
        .article-list {
            display: flex;
            flex-wrap: wrap; /* Wrap items to new line if needed */
            list-style: none;
            padding: 10;
            text-align: center; /* Center text within the item */
        }
        .article-item {
            width: calc(25.33% - 20px); /* Adjust width as needed */
            margin: 40px;
            padding: 20px;
            border: 1px solid #ddd;
        }
        .title{
            text-align: center;
        }
        .comments-container {
            border: 1px solid #000000;
            max-height: 100px; /* Set the maximum height to enable scrolling */
            overflow-y: auto; /* Enable vertical scrolling if needed */
            margin: 10px; /* Add spacing above the comments */
            border-radius: 10px;
        }

        .comment {
            margin-bottom: 10px; /* Add spacing between comments */
        }

    </style>
</head>
<body>

 <h3>Welcome <?php echo $_SESSION['username']   ?> ! </h3>
    
 <h1 class="title">Home Page</h1>

<form method="post">
    <button type="submit" name="addA">Add Articles</button>
</form>

<form method="post">
    <button type="submit" name="logout">Logout</button>
</form>

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