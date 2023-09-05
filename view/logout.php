<?php 
include_once '../controller/userC.php';
session_start();
$userC=new userC();
$userC->logout();
header('location:login.php');
?>