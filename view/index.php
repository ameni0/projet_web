<?php
include_once '../controller/userC.php';
include_once '../controller/articleC.php';
include_once '../controller/commentaireC.php';
include_once '../controller/ratingC.php';
session_start();

$userC=new userC();
$articleC=new articleC();
$commentaireC=new commentaireC();
$ratingC = new ratingC();


if(isset($_POST['addA'])){
    header('location:addArticle.php');
}

if(isset($_POST['commenter'])&&isset($_SESSION['userID'])){
 
    $comment= new commentaire($_POST['comment'], $_POST['articleID'], $_SESSION['userID']);
    $commentaireC->addCommentaire($comment, $_POST['articleID'], $_SESSION['userID']);
 
}
else if (isset($_POST['commenter'])&&!isset($_SESSION['userID'])) {
    $errors[] = "You must be logged in to comment.";
}

$articles = $articleC->afficher();

if (isset($_GET['search'])) {

    $searchQuery = $_GET['search'];
    $articles = $articleC->search($searchQuery);


} 

if (isset($_GET["tri"]))
   {
    $tri=$_GET["tri"];

    $articles=$articleC->tri($tri);

    if($tri=="none"){
        $articles = $articleC->afficher();
    }
    

   }

 
if (isset($_POST['r'])) {
    $ratingC->modifierRating($_POST['star_rating_option_'. $_POST['articleID'] ], $_POST['articleID'], $_SESSION['userID']);
}
else if (isset($_POST['r'])&&!isset($_SESSION['userID'])) {
    $errors[] = "You must be logged in to rate.";
}


   


 



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/stylesheet.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,100,300,700' rel='stylesheet' type='text/css'>

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	
	<link rel="stylesheet" href="../assets/nav/css/style.css">
    
    <title>Articles</title>

    
</head>
<body>


<div class="container">
    <nav class="navbar navbar-expand-lg ftco_navbar ftco-navbar-light" id="ftco-navbar">
        <div class="container">
            <a class="navbar-brand" href="index.php">Home Page</a>
            <?php if (isset($_SESSION['username'])) {?>
                <ul class="navbar-nav ml-auto mr-md-3">
                    <li class="nav-item"><a href="profile.php" class="nav-link">Profile</a></li>
                    <li class="nav-item"><a href="addArticle.php" class="nav-link">Add Article</a></li>
                    <li class="nav-item"><a href="logout.php" class="nav-link">Logout</a></li>
                </ul>
            <?php } else { ?>
                <ul class="navbar-nav ml-auto mr-md-3">
                    <li class="nav-item"><a href="login.php" class="nav-link">Login</a></li>
                </ul>
            <?php } ?>
        </div>
    </nav>
    <!-- END nav -->
</div>




<h2 class="title">All Articles</h2>
<div class="title">
    <form method="get" id="searchForm" style="display: inline-block; margin-right: 20px;">
        <label for="search">Search Articles:</label>
        <input type="text" id="search" name="search" placeholder="Enter keywords..." onchange="submitSearchForm()">
        <input type="submit" style="display: none;">
    </form>
    
    <form method="get" id="triForm" style="display: inline-block; margin-left: 20px;">
        <label for="tri">Sort by:</label>
        <select id="tri" name="tri" onchange="submitTriForm()">
            <option value="none"></option>
            <option value="type" <?php if (isset($_GET['tri']) && $_GET['tri'] === 'type') echo 'selected'; ?>>Type</option>
            <option value="titre" <?php if (isset($_GET['tri']) && $_GET['tri'] === 'titre') echo 'selected'; ?>>Titre</option>
        </select>
        <input type="submit" style="display: none;">
    </form>    
</div>

<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?php echo $error; ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>


    
    
</div>

<ul class="article-list">
    <?php foreach ($articles as $article) {      
        
        
    ?>
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
            <form method="post">
                <input type="hidden" name="articleID" value="<?php echo $article['articleID']; ?>">
                <textarea name="comment" rows="4" cols="40" placeholder="Write a comment" style="resize: none;"></textarea><br>
                <style>
                    .custom-button {
                        background-color: black;
                        color: white;
                        border-radius: 20px;
                        border: none;
                        padding: 10px 20px; /* Adjust padding as needed */
                        cursor: pointer;
                    }
                </style>
                <button type="submit" name="commenter" class="custom-button">Submit Comment</button>
                <br>
                <br>
                
                    

                    
                
                <!-- Star Rating Input -->
                <style>
                    .star-rating {
                        display: inline-block;
                        font-size: 0;
                    }

                    .star-rating input[type="radio"] {
                        display: none;
                    }

                    .star-rating label {
                        font-size: 24px;
                        cursor: pointer;
                        color: #ccc;
                    }

                    .star-rating label:before {
                        content: "\2605"; /* Unicode character for a star */
                    }

                    .star-rating input[type="radio"]:checked ~ label {
                        color: #ffcc00; /* Color for selected stars */
                    }
                </style>


                    <form method="post" name="rateForm_<?php echo $article['articleID']; ?>">
                        <div class="star-rating">
                        <input type="radio" id="star5_<?php echo $article['articleID']; ?>" name="star_rating_option_<?php echo $article['articleID']; ?>" value="5" <?php if ($ratingC->getNote($article['articleID'], $_SESSION['userID']) == 5) echo 'checked'; ?>>
                        <label for="star5_<?php echo $article['articleID']; ?>"></label>
                        <input type="radio" id="star4_<?php echo $article['articleID']; ?>" name="star_rating_option_<?php echo $article['articleID']; ?>" value="4" <?php if ($ratingC->getNote($article['articleID'], $_SESSION['userID']) == 4) echo 'checked'; ?>>
                        <label for="star4_<?php echo $article['articleID']; ?>"></label>
                        <input type="radio" id="star3_<?php echo $article['articleID']; ?>" name="star_rating_option_<?php echo $article['articleID']; ?>" value="3" <?php if ($ratingC->getNote($article['articleID'], $_SESSION['userID']) == 3) echo 'checked'; ?>>
                        <label for="star3_<?php echo $article['articleID']; ?>"></label>
                        <input type="radio" id="star2_<?php echo $article['articleID']; ?>" name="star_rating_option_<?php echo $article['articleID']; ?>" value="2" <?php if ($ratingC->getNote($article['articleID'], $_SESSION['userID']) == 2) echo 'checked'; ?>>
                        <label for="star2_<?php echo $article['articleID']; ?>"></label>
                        <input type="radio" id="star1_<?php echo $article['articleID']; ?>" name="star_rating_option_<?php echo $article['articleID']; ?>" value="1" <?php if ($ratingC->getNote($article['articleID'], $_SESSION['userID']) == 1) echo 'checked'; ?>>
                        <label for="star1_<?php echo $article['articleID']; ?>"></label>
                        </div>
                        <div>
                            <input type="submit" name="r" value="Rate" class="custom-button">
                            
                        </div>
                    </form>
                
               

            </form>

            

        </li>
    <?php }?>
</ul>


</body>




    <script>
        function submitSearchForm() {
            document.getElementById("searchForm").submit();
        }
        function submitTriForm() {
            document.getElementById("triForm").submit();
        }

        
        
       
    </script>



    <script src="../assets/nav/js/jquery.min.js"></script>
    <script src="../assets/nav/js/popper.js"></script>
    <script src="../assets/nav/js/bootstrap.min.js"></script>
    <script src="../assets/nav/js/main.js"></script>


</html>