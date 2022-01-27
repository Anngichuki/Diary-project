<?php
session_start();
if(array_key_exists("email", $_COOKIE)) {
    $_SESSION['email'] = $_COOKIE['email'];
}
if (array_key_exists("email", $_SESSION)) {
    echo "Logged In! <a href='index.php?logout=1'>Log out</a>";

    include("connection.php");
    $email = mysqli_real_escape_string($link, $_SESSION['email']);
    $query = "SELECT diary FROM `users` WHERE email = '$email' LIMIT 1";

    $row = mysqli_fetch_array(mysqli_query($link,$query));
    $diaryContent = $row['diary'];


}else {
    header("Location: index.php");
}

include("header.php");

?>

<div class="container-fluid">
<textarea id="diary" class="form-control">
    <?php
    echo $diaryContent;
    ?>
</textarea>

</div>

<?php
include("footer.php");
?> 

