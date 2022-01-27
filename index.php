<?php
session_start();
$error = "";
if (array_key_exists("logout", $_GET)) {
    unset($_SESSION);
    setcookie("email", "", time() - 60 * 60);
    $_COOKIE["email"] = "";
    session_destroy();

} else if (array_key_exists("email", $_SESSION) or array_key_exists("email", $_COOKIE)) {
    header("Location: diary.php");
}

if (array_key_exists("submit", $_POST)) {
    include("connection.php");
    $email = mysqli_real_escape_string($link, $_POST['email']);
    

    if (!$_POST['email']) {
        $error .= "An email address is required<br>";
    }
    if (!$_POST['password']) {
        $error .= 'A password is required<br>';
    }

    if ($error != "") {
        $error = "<p> There were error(s) in your form: </p>" . $error;
    } else {
        if ($_POST['signUp'] == '1') {


            $password = mysqli_real_escape_string($link, $_POST['password']);

            $query = "SELECT `id` FROM `users` WHERE email = '$email'";
            $result = mysqli_query($link, $query);
            if (mysqli_num_rows($result) > 0) {
                $error =  "That email address has already been taken";
            } else {
                $email = mysqli_real_escape_string($link, $_POST['email']);
                $password = mysqli_real_escape_string($link, $_POST['password']);
                $newpassword = md5($password);

                $query = "INSERT INTO `users` (`email`, `password`) VALUES ('$email', '$newpassword')";
                if (mysqli_query($link, $query)) {
                    $_SESSION['email'] = $email;


                    if ($_POST['stayLoggedIn'] == '1') {
                        setcookie("email", $email, time() +
                            60 * 60 * 24 * 365);
                    }

                    header("location: diary.php");
                } else {
                    $error =  "there's an error in signing you up<br>";
                }
            }
        } else {
            $query = "SELECT * FROM `users` WHERE email = '$email' ";
            $result = mysqli_query($link, $query);

            $row = mysqli_fetch_array($result);
            if (isset($row)) {
                $hashedPassword = md5($_POST['password']);

                if ($hashedPassword == $row['password']) {
                    $_SESSION['email'] = $row['email'];

                    if ($_POST['stayLoggedIn'] == '1') {
                        setcookie("email", $row['email'], time() +
                            60 * 60 * 24 * 365);
                    }

                    header("location: diary.php");
                } else {
                    $error = "That email/password combination could not be found.";
                }
            } else {
                $error = "That email/password combination could not be found.";
            }
        }
    }
}



?>

<?php include("header.php"); ?>


    <div class="container" id = "homePageContainer">

        <h1>Secret Diary</h1>
        <P><strong>Store your thoughts permanently and securely. </strong></P>
        <div class="row">
            <form method="POST" id="signUpForm">
                <P>Interested? Sign up now</P>

                <fieldset class="form-group">
                    <input type="email" class="form-control" name="email" placeholder="Your email">
                </fieldset>

                <fieldset class="form-group">
                    <input type="password" class="form-control" name="password" placeholder="Password">
                </fieldset>
                <fieldset class="form-group">
                    <input type="checkbox" name="stayLoggedIn" value=1>
                    Stay logged in
                    <input type="hidden" name="signUp" value="1">
                </fieldset>

                <fieldset class="form-group">
                    <input type="submit" class="btn btn-success" name="submit" value="Sign Up">
                </fieldset>
                <p>
                    <a class="toggleForms">Log In </a>
                </p>
            </form>

            <form method="POST" id="logInForm">

            <P>Log in using your username and password</P>

                <fieldset class="form-group">
                    <input class="form-control" type="email" name="email" placeholder="Your email">
    </fieldset>
                <br>
                <fieldset class="form-group">
                    <input class="form-control" type="password" name="password" placeholder="Password">
                </fieldset>
                <br>
                <fieldset class="form-group">
                    <input type="checkbox" name="stayLoggedIn" value=1>
                    Stay logged in
                </fieldset>
                <br>
                <fieldset class="form-group">
                    <input type="hidden" name="signUp" value="0">
                </fieldset>

                <fieldset class="form-group">
                    <input type="submit" class="btn btn-success" name="submit" value="Log In">
                </fieldset>

                <p>
                    <a class="toggleForms">Sign Up </a>
                </p>

            </form>
        </div>
    </div>
    <div id="error"> <?php echo $error; ?>
    </div>
    
    <?php include("footer.php"); ?>