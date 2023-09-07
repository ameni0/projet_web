<?php
session_start();

include_once '../controller/articleC.php';
include_once '../controller/userC.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php"); 
    exit();
}

$articleC=new articleC();

$articles = $articleC->getArticlesByUserID($_SESSION['userID']); 

$userC = new UserC();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    if (isset($_POST['deleteArticle'])) {
        $articleC->supprimer($_POST['articleID']);
        header('location:profile.php');
    }
    
    if (isset($_POST['updateArticle'])) {
        $image = $_FILES['image'];
    

        
        if (empty($_POST['titre'])) {
            $errors[] = "Title is empty";
        } elseif (strlen($_POST['titre']) > 10) {
            $errors[] = "Title cannot be longer than 10 characters";
        } elseif (preg_match('/[0-9]/', $_POST['titre'])) {
            $errors[] = "Title cannot contain numbers";
        }

      
        if (empty($_POST['type'])) {
            $errors[] = "Type is empty";
        }

        
        if (empty($_POST['description'])) {
            $errors[] = "Description is empty";
        } elseif (strlen($_POST['description']) <= 8) {
            $errors[] = "Description must be longer than 8 characters";
        }


       
        if (empty($errors)) {
            $articleC = new articleC();
            $path = $articleC->upload_image('../assets/articles/', $image);

            $article = new Article(
                $_POST['titre'],
                $_POST['type'],
                $path,
                $_POST['description'],
                $_SESSION['userID']
            );

            $articleC->modifierArticle($article, $path, $_POST['articleID']);
            header('location:profile.php');
            exit;
        }
    }
    
    if (isset($_POST['deleteAccount'])) {

        $userC->supprimer($_SESSION['userID']);
        $userC->logout();
        header('location:login.php');

    }

    if (isset($_POST['updateProfile'])) {
        $userC = new UserC();

        if (empty($_POST['username'])) {
            $errors[] = "Username is empty";
        } elseif (strlen($_POST['username']) >= 10) {
            $errors[] = "Username must be Shorter than 10 characters";
        } elseif (preg_match('/[0-9]/', $_POST['username'])) {
            $errors[] = "Username cannot contain numbers";
        }
        if (empty($_POST['password'])) {
            $errors[] = "Password is empty";
        } elseif (strlen($_POST['password']) <= 7) {
            $errors[] = "Password must be longer than 8 characters";
        } elseif ($_POST['password'] !== $_POST['confirm_password']) {
            $errors[] = "Passwords do not match";
        }

        

        if (empty($errors)) {
            $user = new User(
                $_POST['username'],
                $_POST['password']
            );

            $userC->modifierUtilisateur($user, $_SESSION['userID']);
           
            
            $_SESSION['username']=$user->getUsername();
            $_SESSION['password']=$user->getPassword();
            
           
            
            header('location:profile.php');
            exit;
        }
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
    <?php if (!empty($errors)): ?>
                    <div class="alert alert-danger">
                        <ul>
                            <?php foreach ($errors as $error): ?>
                                <li><?php echo $error; ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
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
                    <style>
                        .custom-button {
                            background-color: black;
                            color: white;
                            border-radius: 20px;
                            border: none;
                            padding: 10px 20px; /* Adjust padding as needed */
                            cursor: pointer;
                        }
                        .modify-article-button {
                            background-color: black;
                            color: white;
                            border-radius: 20px;
                            border: none;
                            padding: 10px 20px; /* Adjust padding as needed */
                            cursor: pointer;
                        }
                     </style>
                  
                    <button type="button" class="modify-article-button" data-articleid="<?php echo $article['articleID']; ?>">Modify Article</button>
                    
                    <form method="post" style="display: none;" enctype="multipart/form-data">
                        <input type="hidden" name="articleID" value="<?php echo $article['articleID']; ?>">
                        <label for="titre">Title:</label>
                        <input type="text" id="titre" name="titre" ><br><br>

                        <label for="type">Type:</label>
                        <select id="type" name="type" >
                        <option value="Beaute">Beaute</option>
                    <option value="Sante">Sante</option>
                    <option value="Voyage">Voyage</option>
                        </select><br>

                        <label for="description">Description:</label>
                        <textarea id="description" name="description" rows="3" cols="40" style="resize: none;"  ></textarea><br><br>

                        <label for="image">Image:</label>
                        <input type="file" id="image" name="image" accept="image/*"  onchange="displaySelectedImage(this)"><br><br>
                        <button type="submit" name="updateArticle" class="custom-button">Save Article</button>
                    </form>
                    <br></br>

                   
                    <form method="post">
                        <input type="hidden" name="articleID" value="<?php echo $article['articleID']; ?>">
                        <button type="submit" name="deleteArticle" class="custom-button">Delete Article</button>
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
        <!-- Username Input -->
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="<?php echo $_SESSION['username']; ?>" readonly>
        </div>
        <!-- Password Input -->
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" readonly>
        </div>
        <!-- Confirm Password Input -->
        <div class="form-group">
            <label for="confirm_password">Confirm Password:</label>
            <input type="password" id="confirm_password" name="confirm_password" readonly>
        </div>
        <!-- "Update Profile" Button -->*
        
        <button type="submit" name="updateProfile" id="updateProfileButtonProfile" class="custom-button" style="display: none;" name="updateProfile">Update Profile</button>
        <button type="button" id="editProfileButton" class="custom-button" >Edit Profile</button>
        
    </form>


   

    <h2>Delete Your Account</h2>
    <form method="post">
        <p>Are you sure you want to delete your account? This action is irreversible.</p>
        <button type="submit" name="deleteAccount" class="custom-button">Delete Account</button>
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
    // Function to toggle the read-only state of input fields
    function toggleInputFields(readonly) {
        const usernameInput = document.getElementById('username');
        const passwordInput = document.getElementById('password');
        const confirmPasswordInput = document.getElementById('confirm_password');

        usernameInput.readOnly = readonly;
        passwordInput.readOnly = readonly;
        confirmPasswordInput.readOnly = readonly;
    }

    // Function to handle the "Edit Profile" button click
    document.getElementById('editProfileButton').addEventListener('click', () => {
        toggleInputFields(false); // Unlock the input fields
        document.getElementById('updateProfileButtonProfile').style.display = 'block'; // Show the "Update Profile" button

        document.getElementById('editProfileButton').style.display = 'none'; // Hide the "Edit Profile" button
    });
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
