<?php
session_start();
 $_SESSION['username'] = "robpercival";
 if($_SESSION['email'] ){
  //   echo 'you are logged in';

 }else{
    echo 'you are not loggedd in';
    header("location: index.php");
 }
 ?>
 