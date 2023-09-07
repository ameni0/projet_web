<?php session_start(); 
include '../controller/userC.php';
include '../controller/articleC.php';


$uC=new userC();
$articleC=new articleC();
$articles = $articleC->afficher();
$users =$uC->afficher();

$filteredUsers = array_filter($users, function ($user) {
    return $user['username'] !== 'admin';
});


$users = $filteredUsers;

if (isset($_GET["tri"]))
   {
    $tri=$_GET["tri"];
    
 
    $users = $uC->tri($tri);
    $filteredUsers = array_filter($users, function ($user) {
        return $user['username'] !== 'admin';
    });
    $users = $filteredUsers;

   }




if(isset($_GET['recherche']))
{
    $search_value=$_GET["recherche"];
    $usersData = $uC->search($search_value);
    $users = $usersData->fetchAll(PDO::FETCH_ASSOC);
    $filteredUsers = array_filter($users, function ($user) {
        return $user['username'] !== 'admin';
    });
    $users = $filteredUsers;
}

if(isset($_POST['ban'])||isset($_POST['unban']))
{
    $userID=$_POST['userID'];
    $uC->BanStatus($userID);
    header('location:dashboardBack.php');
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
                        <li><a href="logout.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
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
                    <a href="dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a>
                </li>
                <li>
                    <a class="active-menu" href="dashboardUser.php"><i class="fa fa-desktop"></i> Gestion User</a>
                </li>
                <li>
                    <a href="dashboardArticle.php"><i class="fa fa-bar-chart-o"></i> Gestion Article</a>
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
                            Gestion <small>User</small>
                        </h1>
                    </div>
                </div>

                <div class="row">
                   
                    <div class="col-md-8 col-sm-12 col-xs-12">

                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Article Table 
                            </div>
                           
                            <div class="panel-body">             
                              
            <form  method="get" action="">
                <div>
                    <input style="margin-left:240px" type="text"  placeholder="Rechercher User" aria-label="Search" aria-describedby="basic-addon2" name="recherche">   
                    <input  type="submit" name="submit" value="recherche">
                </div>
            </form>

            <form method="get" id="triForm" style="display: inline-block; margin-left: 20px;">
                <label for="tri">Sort by:</label>
                <select id="tri" name="tri" onchange="submitTriForm()">
                    <option value="none"></option>
                    <option value="usernam" <?php if (isset($_GET['tri']) && $_GET['tri'] === 'username') echo 'selected'; ?>>username</option>
                    
                </select>
                <input type="submit" style="display: none;">
            </form>


        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover">
                <thead>
                    <tr> 
                        <th>Username</th>
                        <th>Number of Articles</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                                        <?php

            foreach ($users as  $u){
                $articles = $articleC->getNbArticlesByUserId($u['userID']);
                
                    
                
        ?>
        
        <tr>
                                            
            <td><?php echo $u['username'];?></td>
            <td><?php echo $articles;?></td>
            <td>
            
            <?php
            if($u['status']=='Banned'){
                                                            
            ?>
            <form method="POST" >
            <input type="submit" name="unban" value="UnBan">
            <input type="hidden" name="userID" value="<?php echo $u ['userID'];?>">
            </form>
            
            <?php
            }
            else{
            ?>
            <form method="POST" >
                <input type="submit" name="ban" value="Ban">
                <input type="hidden" name="userID" value="<?php echo $u ['userID'];?>">
            <?php }?>
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

    <script>
        function submitTriForm() {
            document.getElementById("triForm").submit();
        }
    </script>
        


</body>

</html>