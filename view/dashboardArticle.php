<?php session_start(); 
include '../controller/userC.php';
include '../controller/articleC.php';
include '../controller/commentaireC.php';


$uC=new userC();
$articleC=new articleC();
$commentaireC=new commentaireC();

$articles = $articleC->afficher();
$users =$uC->afficher();
if (isset($_GET["tri"]))
   {
    $tri=$_GET["tri"];
    
 
    $articles=$articleC->tri($tri);

   }


if(isset($_GET['recherche']))
{
    $search_value=$_GET["recherche"];
    $articles=$articleC->search($search_value);
}

if(isset($_POST['delete']))
{
    $articleID=$_POST['articleID'];
    $articleC->supprimer($articleID);
    header('location:dashboardArticle.php');
}

if (isset($_POST["deleteC"]) && isset($_POST["commentID"])) {
   
    $commentID = $_POST["commentID"];
    
    $commentaireC->supprimer($commentID);
    
} 




?>



<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Back</title>
    <!-- Bootstrap Styles-->
    <link href="../assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FontAwesome Styles-->
    <link href="../assets/css/font-awesome.css" rel="stylesheet" />
    <!-- Morris Chart Styles-->
    <link href="../assets/js/morris/morris-0.4.3.min.css" rel="stylesheet" />
    <!-- Custom Styles-->
    <link href="../assets/css/custom-styles.css" rel="stylesheet" />
    <!-- Google Fonts-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
    <script async src="https://api.countapi.xyz/hit/codefoxx.com/b461abc5-f841-4008-ac9b-d2112a425f40?callback=websiteVisits"></script>
</head>

<body>
    <div id="wrapper">
        <nav class="navbar navbar-default top-navbar" role="navigation">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <h1><a href="#body"><img src="../assets/asdf.png" alt="" title="" /></a></h1>
                
            </div>

            <ul class="nav navbar-top-links navbar-right">
                
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                        <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li class="divider"></li>
                        <li><a href="#"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
        </nav>
        <!--/. NAV TOP  -->
        <nav class="navbar-default navbar-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="main-menu">

                <li>
                    <a  href="dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a>
                </li>
                <li>
                    <a  href="dashboardUser.php"><i class="fa fa-desktop"></i> Gestion User</a>
                </li>
                <li>
                    <a class="active-menu" href="dashboardArticle.php"><i class="fa fa-bar-chart-o"></i> Gestion Article</a>
                </li>
                  
                </ul>

            </div>

        </nav>
        <!-- /. NAV SIDE  -->
        <div id="page-wrapper">
            <div id="page-inner">


                <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-header">
                            Gestion <small>Article</small>
                        </h1>
                    </div>
                </div>

                <div class="row">
                   
                    <div class="col-md-8 col-sm-12 col-xs-12">

                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Client Table 
                            </div>
                           
                            <div class="panel-body">             
                              
            <form  method="get" action="">
                <div>
                    <input style="margin-left:240px" type="text"  placeholder="Rechercher User" aria-label="Search" aria-describedby="basic-addon2" name="recherche">   
                    <input  type="submit" name="submit" value="recherche">
                </div>
            </form>


        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover">
                <thead>
                    
                    <tr>
                        
                        <th>Titre</th>
                        <th>Type</th>
                        <th>Image</th>
                        <th>Description</th>
                        <th>Author</th>
                        <th>Comments</th>
                        <th>Actions</th>
                        
                    </tr>
                </thead>
                <tbody>
           <?php

            foreach ($articles as  $article){
                $username = $uC->getUsernameById($article['userID']);
                $comments = $articleC->getCommentsByArticleId($article['articleID']);
            ?>
        
        <tr>
                                            
            <td><?php echo $article['titre'];?></td>
            <td><?php echo $article['type']?></td>
            <td><img src="<?php echo $article['image']; ?>" width="50" height="50"></td>
            <td><?php echo $article['description']?></td>
            <td><?php echo $username?></td>
            <td>
                <button class="toggle-comments-button">Show Comments</button>
                <div class="comments-container" style="display: none;"> 
                    <?php
                    // Fetch comments for the current article from the database
                    $comments = $commentaireC->afficher($article['articleID']);

                    if (!empty($comments)) {
                        foreach ($comments as $c) {
                            $name = $uC->getUsernameById($c['userID']);
                           // echo "<div class='comment' name='deleteC' >";
                            echo "<form method='POST' class='delete-comment-form'>";
                            echo "<input type='hidden' name='commentID' value='{$c['cID']}'>";
                            echo "<p><strong>{$name}:</strong> {$c['text']} <button type='submit' name='deleteC'  class='delete-comment-button' data-comment-id='{$c['cID']}'>Delete</button></p>";
                            echo "</form>";
                           // echo "</div>";
                        }
                    } else {
                        echo "<p>No comments yet.</p>";
                    }
                    ?>
                </div>
            </td>

            <td>
                <form method="POST" >
                    <input type="submit" name="delete" value="Delete" >
                    <input type="hidden" name="articleID" value="<?php echo $article ['articleID'];?>">
                </form>
            </td>    
            </tr>
            </tbody>  
        <?php } ?>  
        </table>
        
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- /. ROW  -->
				
            </div>
            <!-- /. PAGE INNER  -->
        </div>
        <!-- /. PAGE WRAPPER  -->
    </div>
    <!-- /. WRAPPER  -->
    <!-- JS Scripts-->
      <!-- JS Scripts-->
      <script src="../assets/js/main.js"></script>
    <!-- jQuery Js -->
    <script src="../assets/js/jquery-1.10.2.js"></script>
    <!-- Bootstrap Js -->
    <script src="../assets/js/bootstrap.min.js"></script>
    <!-- Metis Menu Js -->
    <script src="../assets/js/jquery.metisMenu.js"></script>
    <!-- Morris Chart Js -->
    <script src="../assets/js/morris/raphael-2.1.0.min.js"></script>
    <script src="../assets/js/morris/morris.js"></script>
    <!-- Custom Js -->
    <script src="../assets/js/custom-scripts.js"></script>
    <!-- Remove one of the duplicate jQuery script tags -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            // JavaScript code for toggling comments
            $(".toggle-comments-button").click(function() {
                var $commentsContainer = $(this).next(".comments-container");
                $commentsContainer.toggle();

                // Toggle button text
                if ($commentsContainer.is(":visible")) {
                    $(this).text("Hide Comments");
                } else {
                    $(this).text("Show Comments");
                }
            });
            
        $(".delete-comment-button").click(function() {
            var commentID = $(this).data("comment-id");
            var $comment = $(this).closest(".comment");
            var $commentsContainer = $comment.closest(".comments-container");

            $.ajax({
                url: "dashboardArticle.php",
                type: "POST",
                data: {
                    deleteC: true,
                    commentID: commentID
                },
                success: function() {
                    $comment.remove();
                    if ($commentsContainer.find(".comment").length == 0) {
                        $commentsContainer.html("<p>No comments yet.</p>");
                    }
                }
            });
        });

            
        });
    </script>




</body>

</html>