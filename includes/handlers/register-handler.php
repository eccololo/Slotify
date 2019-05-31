<?php
    function sanitizeFormUsername($formInput) {
        $formInput = strip_tags($formInput);
        $formInput = str_replace(" ", "", $formInput);
        return $formInput;
    }

    function sanitizeFormString($formInput) {
        $formInput = strip_tags($formInput);
        $formInput = str_replace(" ", "", $formInput);
        $formInput = ucfirst(strtolower($formInput));
        return $formInput;
    }

    function sanitizeFormPassword($formInput) {
        $formInput = strip_tags($formInput);
        return $formInput;
    }

    if(isset($_POST['registerButton'])) {
        //Register button was pressed.
        $username = sanitizeFormUsername($_POST['username']);
        $firstName = sanitizeFormString($_POST['firstName']);
        $lastName = sanitizeFormString($_POST['lastName']);
        $email = sanitizeFormString($_POST['email']);
        $email2 = sanitizeFormString($_POST['email2']);
        $password = sanitizeFormPassword($_POST['password']);
        $password2 = sanitizeFormPassword($_POST['password2']); 

        $wasSuccessful = $account->register($username, $firstName, $lastName, $email, $email2, $password, $password2);
        
        if($wasSuccessful) {
            header("Location: index.php");
        } else {
            //TODO: Zmienic w wersji ostatecznej.
            echo "<h1>Registration Failed: " . mysqli_error($account->getCon()) . "</h1>";
        }
    }
?>