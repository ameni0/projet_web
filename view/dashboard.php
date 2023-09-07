<?php session_start(); 
include '../controller/userC.php';
include '../controller/articleC.php';
include '../controller/commentaireC.php';

$uC=new userC();




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
                    <a  class="active-menu" href="dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a>
                </li>
                <li>
                    <a  href="dashboardUser.php"><i class="fa fa-desktop"></i> Gestion User</a>
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
                            Dashboard
                        </h1>
                    </div>
                </div>

                <div class="row">
                   
                    <div class="col-md-8 col-sm-12 col-xs-12">

                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Statistiques 
                            </div>
                           
                            <div class="panel-body">
                                <canvas id="donutChart" width="400" height="400"></canvas>
                            </div>
            
                              
            


           
        
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
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- JavaScript for rendering the donut chart -->
<script>
    // Function to calculate statistics and render the donut chart
    function renderDonutChart(usersWithArticlesCount, usersWithoutArticlesCount) {
        

        // Get the canvas element
        const canvas = document.getElementById('donutChart');

        // Create the donut chart
        new Chart(canvas, {
            type: 'doughnut',
            data: {
                labels: ['Users with Articles', 'Users without Articles'],
                datasets: [{
                    data: [usersWithArticlesCount, usersWithoutArticlesCount],
                    backgroundColor: ['#36A2EB', '#FFCE56'],
                }],
            },
        });
    }

    <?php
    // Call the getUsersWithArticles function to get the count of users with articles
    $usersWithArticlesCount = $uC->getUsersWithArticles();
    $usersWithoutArticlesCount = $uC->getUsersCount() - $usersWithArticlesCount;
    // Pass the count to the JavaScript function
    echo "renderDonutChart($usersWithArticlesCount, $usersWithoutArticlesCount );";
    ?>
</script>


  



</body>

</html>