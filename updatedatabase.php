<?php
session_start();
if (array_key_exists("content", $_POST)) {
    include("connection.php");
    $content = mysqli_real_escape_string($link, $_POST['content']);
    $email = mysqli_real_escape_string($link, $_SESSION["email"]);

    $query = "UPDATE `users` SET `diary` = '$content' WHERE email ='$email' ";
    
    mysqli_query($link, $query);
    
    
}




?>