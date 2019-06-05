<?php
    include("includes/config.php");
    include("includes/classes/Account.php");
    include("includes/classes/Constants.php");
    
    //$con to nasze polaczenie z baza danych
    $account = new Account($con);
    
    
    include("includes/handlers/register-handler.php");
    include("includes/handlers/login-handler.php");

    function getInputValue($name) {
        if(isset($_POST[$name])) {
            echo $_POST[$name];
        }
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="assets/css/register.css">
    <!-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css"> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <!-- <script src="https://kit.fontawesome.com/bbf2983d3d.js"></script> -->
    <title>Welcome to Slotify!</title>
</head>

<body>
    <?php
        if(isset($_POST['registerButton'])) {
            echo '<script>$(document).ready(function() {
                    $("#loginForm").hide();
                    $("#registerForm").show();
                  });</script>';
        } else {
            echo '<script>$(document).ready(function() {
                    $("#loginForm").show();
                    $("#registerForm").hide();
                 });</script>';
        }

    ?>

    <div id="background">
        <div id="loginContainer">
            <div id="inputContainer">
                <form action="register.php" method="post" id="loginForm">
                    <h2>Login to your account</h2>
                    <p>
                        <?php echo $account->getError(Constants::$loginFailed); ?>
                        <label for="loginUsername">Username</label>
                        <input type="text" id="loginUsername" name="loginUsername" placeholder="e.g. Family_Guy" required>
                    </p>

                    <p>
                        <label for="loginPassword">Password</label>
                        <input type="password" id="loginPassword" name="loginPassword" placeholder="Your password" required>
                    </p>
                    <button type="submit" name="loginButton">LOG IN</button>
                    <div class="hasAccountText">
                        <span id="hideLogin">Don't have account yet? Signup here.</span>
                    </div>
                </form>

                <form action="register.php" method="post" id="registerForm">
                    <h2>Create your free account</h2>
                    <p>
                        <?php echo $account->getError(Constants::$usernameCharacters); ?>
                        <?php echo $account->getError(Constants::$usernameTaken); ?>
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" placeholder="e.g. Family_Guy"
                            value="<?php getInputValue('username'); ?>" required>
                    </p>

                    <p>
                        <?php echo $account->getError(Constants::$firstNameCharacters); ?>
                        <label for="firstName">First name</label>
                        <input type="text" id="firstName" name="firstName" placeholder="e.g. Kola"
                            value="<?php getInputValue('firstName'); ?>" required>
                    </p>

                    <p>
                        <?php echo $account->getError(Constants::$lastNameCharacters); ?>
                        <label for="lastName">Last name</label>
                        <input type="text" id="lastName" name="lastName" placeholder="e.g. Spaniard"
                            value="<?php getInputValue('lastName'); ?>" required>
                    </p>

                    <p>
                        <?php echo $account->getError(Constants::$emailsDoNotMatch); ?>
                        <?php echo $account->getError(Constants::$emailInvalid); ?>
                        <?php echo $account->getError(Constants::$emailTaken); ?>
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" placeholder="e.g. guy@gmail.com"
                            value="<?php getInputValue('email'); ?>" required>
                    </p>

                    <p>
                        <label for="email2">Confirm email</label>
                        <input type="email" id="email2" name="email2" placeholder="e.g. guy@gmail.com"
                            value="<?php getInputValue('email2'); ?>" required>
                    </p>

                    <p>
                        <?php echo $account->getError(Constants::$passwordsDoNotMatch); ?>
                        <?php echo $account->getError(Constants::$passwordsNotAlphanumeric); ?>
                        <?php echo $account->getError(Constants::$passwordsCharacters); ?>
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" placeholder="Your password" required>
                    </p>

                    <p>
                        <label for="password2">Confirm password</label>
                        <input type="password" id="password2" name="password2" placeholder="Your password" required>
                    </p>
                    <button type="submit" name="registerButton">SIGN UP</button>
                    <div class="hasAccountText">
                        <span id="hideRegister">Already have an account? Log in here.</span>
                    </div>
                </form>
           </div>
           <div id="loginText">
                <h1>Get great music, right now!</h1>
                <h2>Listen to loads of songs for free.</h2>
                <ul>
                    <li><i class="fas fa-check"></i> Discover music you fall in love with.</li>
                    <li><i class="fas fa-check"></i> Create your own playlists.</li>
                    <li><i class="fas fa-check"></i> Follow artists to keep up to date.</li>
                </ul>
           </div>
        </div>
    </div>
    <script src="assets/js/register.js" type="text/javascript"></script>
</body>

</html>