<?php
session_start();

include_once '../controller/articleC.php';
include_once '../controller/userC.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php"); 
    exit();
}

$articleC=new articleC();

$articles = $articleC->getArticlesByUserID($_SESSION['userID']); // Replace 'user_id' with the actual session key for user ID

$userC = new UserC();

// Handle form submissions (e.g., for updating user data or deleting the account)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    if (isset($_POST['deleteArticle'])) {
        $articleC->supprimer($_POST['articleID']);
        header('location:profile.php');
    }
    
    if (isset($_POST['updateArticle'])) {
        $image = $_FILES['image'];

        $userID = $_SESSION['userID'];

        $path=$articleC->upload_image('../assets/articles/', $image);
        
        $article = new Article(
            $_POST['titre'],
            $_POST['type'],
            $path,
            $_POST['description'],
            $userID
        );

        $articleC->modifierArticle($article, $path, $_POST['articleID']);
        header('location:profile.php');
    }
    
    if (isset($_POST['deleteAccount'])) {

        $userC->supprimer($_SESSION['userID']);
        $userC->logout();
        header('location:login.php');

    }
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
    <title>Profile</title>
</head>
<body>

    <div class="container">
    <nav class="navbar navbar-expand-lg ftco_navbar ftco-navbar-light" id="ftco-navbar">
        <div class="container">
            <a class="navbar-brand" href="index.php">Home Page</a>
                <ul class="navbar-nav ml-auto mr-md-3">
                    <li class="nav-item"><a href="profile.php" class="nav-link">Profile</a></li>
                    <li class="nav-item"><a href="addArticle.php" class="nav-link">Add Article</a></li>
                    <li class="nav-item"><a href="logout.php" class="nav-link">Logout</a></li>
                </ul>
        </div>
    </nav>
    <!-- END nav -->
</div>


    <h1 class="title">Welcome, <?php echo $_SESSION['username']; ?>!</h2>
    <h2 class="title">These are your Articles.</h1>
    <div>
        <ul class="article-list">
            <?php if (!empty($articles)) {
                foreach ($articles as $article) {
            ?>
                <li class="article-item">
                    <h3><?php echo $article['titre']; ?></h3>
                    <img src="<?php echo $article['image']; ?>" width="150" height="150">
                    <p>Type: <?php echo $article['type']; ?></p>
                    <p>Description: <?php echo $article['description']; ?></p>
                  
                    <button type="button" class="modify-article-button" data-articleid="<?php echo $article['articleID']; ?>">Modify Article</button>
                    
                    <form method="post" style="display: none;">
                        <input type="hidden" name="articleID" value="<?php echo $article['articleID']; ?>">
                        <label for="titre">Title:</label>
                        <input type="text" id="titre" name="titre" required><br><br>

                        <label for="type">Type:</label>
                        <select id="type" name="type" required>
                            <option value="bouk">Bouk</option>
                            <option value="omek">Omek</option>
                        </select><br>

                        <label for="description">Description:</label>
                        <textarea id="description" name="description" rows="3" cols="40" style="resize: none;" required ></textarea><br><br>

                        <label for="image">Image:</label>
                        <input type="file" id="image" name="image" accept="image/*" required onchange="displaySelectedImage(this)"><br><br>
                        <button type="submit" name="updateArticle">Save Article</button>
                    </form>
                   
                    <form method="post">
                        <input type="hidden" name="articleID" value="<?php echo $article['articleID']; ?>">
                        <button type="submit" name="deleteArticle">Delete Article</button>
                    </form>
            </li>
            <?php }} else {
                            echo "<p style='center';>You don't have any Articles yet.</p>";
                        }?>
        </ul>
    </div>
    <div class="title">                       
    <h2>Modify Your Profile</h2>
    <form method="post">
        <!-- Add input fields for updating user data (e.g., username, email, etc.) -->
        <button type="submit" name="updateProfile">Update Profile</button>
    </form>

    <h2>Delete Your Account</h2>
    <form method="post">
        <p>Are you sure you want to delete your account? This action is irreversible.</p>
        <button type="submit" name="deleteAccount">Delete Account</button>
    </form>
    </div>
</body>
<script>
function displaySelectedImage(input) {
    const selectedImageName = document.getElementById('selectedImageName');

    if (input.files.length > 0) {
        selectedImageName.textContent = 'Selected image: ' + input.files[0].name;
    } else {
        selectedImageName.textContent = ''; // Clear the message if no file is selected
    }
}
</script>

<script>
    // JavaScript code to toggle between article details and update form
    const modifyButtons = document.querySelectorAll('.modify-article-button');

    modifyButtons.forEach(button => {
        button.addEventListener('click', () => {
            const articleId = button.getAttribute('data-articleid');
            const articleItem = button.closest('.article-item');
            const articleDetails = articleItem.querySelectorAll('h3, img, p, form');
            const updateForm = articleItem.querySelector('form');

            articleDetails.forEach(detail => {
                detail.style.display = 'none';
            });

            updateForm.style.display = 'block';
            button.style.display = 'none';
        });
    });

    
</script>

    <script src="../assets/nav/js/jquery.min.js"></script>
    <script src="../assets/nav/js/popper.js"></script>
    <script src="../assets/nav/js/bootstrap.min.js"></script>
    <script src="../assets/nav/js/main.js"></script>


</html>
