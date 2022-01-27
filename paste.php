<?php
session_start();
echo $_SESSION['username'];
$link = mysqli_connect("localhost", "root", "root", "ann");

if (mysqli_connect_error()) {
    die("Error");
}

// $myquery = "INSERT INTO users (`email`, `password`)
// VALUES('anndffdddn@gmail.com', 'ffffffff')";

// mysqli_query($link, $myquery);

$query = "SELECT * FROM users";
if ($result = mysqli_query($link, $query)) {

    $row = mysqli_fetch_array($result);
    // print_r($row);

    // echo $row["email"] . "<br>";
}

$query = "UPDATE `users` SET email = 'mwiti@gmail.com' WHERE id = 1";
mysqli_query($link, $query);
$query = "UPDATE `users` SET password = 'pass!@!' WHERE email = 'mwitiderrick@gmail.com'";
mysqli_query($link, $query);

$name = "Derr O' Grady";
$query = "SELECT * FROM `users` WHERE `name` = '" . mysqli_real_escape_string($link, $name) . "' ";
if ($result = mysqli_query($link, $query)) {
    while ($row = mysqli_fetch_array($result)) {
         print_r($row);
        echo $row['email'] . " " . "<br>";
    }
}

if ($_POST) {
    print_r($_POST);
    if ($_POST['email'] == '') {
        echo 'email is required  <br>';
    } else if ($_POST['password'] == '') {
        echo 'enter password <br>';
    } else {
        $query = "SELECT `id` FROM `users` WHERE email = '" . mysqli_real_escape_string($link, $_POST['email']) . "'";
        $result = mysqli_query($link, $query);
        if (mysqli_num_rows($result) > 0) {
            echo "<p>That email address has already been taken.</p>";
        } else {
            $email  = mysqli_real_escape_string($link, $_POST['email']);
            $password = mysqli_real_escape_string($link, $_POST['password']);

            $query = "INSERT INTO `users` (`email`, `password`) VALUES ('$email','$password')";

            if (mysqli_query($link, $query)) {

                echo "<p>You have been signed up!";

                 $_SESSION['email'] = $_POST['email']; 
                 header("location: sessions.php");
            } else {

                echo "<p>There was a problem signing you up - please try again later.</p>";
                echo mysqli_error($link);
            }
        }
    }
}

?>
<p>sign up in the form below</P>
<form method="POST">
    <P> Email address
        <input type="text" name="email" />
    </p>
    <P> Password <input type="password" name="password" />
    </P>
    <input type="submit" value="sign up" />
</form>