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

    header('location:addArticle.php');
}




?>



<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700,900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="../assets/addArticle/fonts/icomoon/style.css">


    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../assets/addArticle/css/bootstrap.min.css">
    
    <!-- Style -->
    <link rel="stylesheet" href="../assets/addArticle/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,100,300,700' rel='stylesheet' type='text/css'>

	  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	
	  <link rel="stylesheet" href="../assets/nav/css/style.css">
    
    <title>Add Article</title>
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
  
  <div class="content">
    
    <div class="container">
      <div class="row align-items-stretch justify-content-center no-gutters">
        <div class="col-md-7">
          <div class="form h-100 contact-wrap p-5">
            <h3 class="text-center">Add Article</h3>
            <form class="mb-5" method="post" action="addArticle.php" id="contactForm" name="contactForm">
              <div class="row">
                <div class="col-md-6 form-group mb-3">
                  <label for="" class="col-form-label">Titre *</label>
                  <input type="text" class="form-control" name="titre" id="titre" >
                </div>
                
                <div class="col-md-6 form-group mb-3">
                  <label for="type" class="col-form-label">Type *</label>
                  <select class="form-control" name="type" id="type">
                    <option value="omek">omek</option>
                    <option value="bouk">bouk</option>
                  </select>
                </div>
              </div>


              <div class="row mb-5">
                <div class="col-md-12 form-group mb-3">
                  <label for="message" class="col-form-label">Description *</label>
                  <textarea class="form-control" name="description" id="description" cols="30" rows="4"  ></textarea>
                </div>
              </div>

              <div class="row">
                <div class="col-md-12 form-group mb-3">
                  <label for="image" class="col-form-label">Image</label>
                  <input type="file" class="form-control" name="image" id="image" accept="image/*" >
                </div>
              </div>

              <div class="row justify-content-center">
                <div class="col-md-5 form-group text-center">
                  <input type="submit" value="Submit" name="submit" class="btn btn-block btn-primary rounded-0 py-2 px-4">
                  <span class="submitting"></span>
                </div>
              </div>
            </form>

          </div>
        </div>
      </div>
    </div>

  </div>
     
    

  </body>

    <script src="../assets/nav/js/jquery.min.js"></script>
    <script src="../assets/nav/js/popper.js"></script>
    <script src="../assets/nav/js/bootstrap.min.js"></script>
    <script src="../assets/nav/js/main.js"></script>  

</html>
