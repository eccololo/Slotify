<?php
    include("includes/classes/Account.php");
    include("includes/classes/Constants.php");
    $account = new Account();
    
    include("includes/handlers/register-handler.php");
    include("includes/handlers/login-handler.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Welcome to Slotify!</title>
</head>

<body>
    <div id="inputContainer">
        <form action="register.php" method="post" id="loginForm">
            <h2>Login to your account</h2>
            <p>
                <label for="loginUsername">Username</label>
                <input type="text" id="loginUsername" name="loginUsername" placeholder="e.g. Family_Guy" required>
            </p>

            <p>
                <label for="loginPassword">Password</label>
                <input type="password" id="loginPassword" name="loginPassword" placeholder="Your password" required>
            </p>
            <button type="submit" name="loginButton">LOG IN</button>
        </form>

        <form action="register.php" method="post" id="registerForm">
            <h2>Create your free account</h2>
            <p>
                <?php echo $account->getError(Constants::$usernameCharacters); ?>
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="e.g. Family_Guy" required>
            </p>

            <p>
                <?php echo $account->getError(Constants::$firstNameCharacters); ?>
                <label for="firstName">First name</label>
                <input type="text" id="firstName" name="firstName" placeholder="e.g. Kola" required>
            </p>

            <p>
                <?php echo $account->getError(Constants::$lastNameCharacters); ?>
                <label for="lastName">Last name</label>
                <input type="text" id="lastName" name="lastName" placeholder="e.g. Spaniard" required>
            </p>

            <p>
                <?php echo $account->getError(Constants::$emailsDoNotMatch); ?>
                <?php echo $account->getError(Constants::$emailInvalid); ?>
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="e.g. guy@gmail.com" required>
            </p>

            <p>
                <label for="email2">Confirm email</label>
                <input type="email" id="email2" name="email2" placeholder="e.g. guy@gmail.com" required>
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
        </form>
    </div>
</body>

</html>
