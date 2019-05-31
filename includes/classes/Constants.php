<?php

class Constants {

    //Registration errors
    public static $passwordsDoNotMatch = "Your passwords don't match.";
    public static $passwordsNotAlphanumeric = "Your passwords can contain only numbers and letters.";
    public static $passwordsCharacters = "Your password must be between 8 and 30 characters.";
    public static $emailInvalid = "Email is invalid.";
    public static $emailsDoNotMatch = "Your emails don't match.";
    public static $emailTaken = "This email is already taken. Use another one.";
    public static $lastNameCharacters = "Your last name must be between 2 and 25 characters.";
    public static $firstNameCharacters = "Your first name must be between 2 and 25 characters.";
    public static $usernameCharacters = "Your username must be between 5 and 25 characters.";
    public static $usernameTaken = "This username is already taken. Use another one.";

    //Login errors
    public static $loginFailed = "Username or password are incorrect.";
    

}

?>