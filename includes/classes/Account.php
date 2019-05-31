<?php
class Account {

    private $errorArray;
    private $con;

    public function __construct($con) {
        $this->errorArray = array();
        $this->con = $con;
    }
    
    public function register($un, $fn, $ln, $em, $em2, $pw, $pw2) {
        $this->validateUsername($un);
        $this->validateFirstName($fn);
        $this->validateLastName($ln);
        $this->validateEmails($em, $em2);
        $this->validatePasswords($pw, $pw2);

        if(empty($this->errorArray)) {
            //Wstaw do bazy danych
            return $this->insertUserDetails($un, $fn, $ln, $em, $pw);
        } else {
            return false;
        }
    }

    public function getError($error) {
        if(!in_array($error, $this->errorArray)) {
            $error = "";
        }
        return "<span class='errorMessage'>$error</span>";
    }

    private function insertUserDetails($un, $fn, $ln, $em, $pw) {
        //Prosta metoda szyfrowania hasla.
        $encryptedPw = md5($pw);
        $profilePic = "assets/images/profile-pics/head_emerald.png";
        $date = date("Y-m-d");

        $sql = "INSERT INTO users VALUES (null, '$un', '$fn', '$ln', '$em', '$encryptedPw', '$date', '$profilePic')";
        $result = mysqli_query($this->con, $sql);

        return $result;
    }

    private function validateUsername($un) {
        if(strlen($un) > 25 || strlen($un) < 5) {
            array_push($this->errorArray, Constants::$usernameCharacters);
            return;
        }

        $sql = "SELECT username FROM users WHERE username = '$un'";
        $checkUsernameQuery = mysqli_query($this->con, $sql);
        //Sprawdza czy resultat z bazy danych zwrocil jakikolwiek wynik 
        if(mysqli_num_rows($checkUsernameQuery) != 0) {
            array_push($this->errorArray, Constants::$usernameTaken);
            return;
        }
    }

    private function validateFirstName($fn) {
        if(strlen($fn) > 25 || strlen($fn) < 2) {
            array_push($this->errorArray, Constants::$firstNameCharacters);
            return;
        }
    }

    private function validateLastName($ln) {
        if(strlen($ln) > 25 || strlen($ln) < 2) {
            array_push($this->errorArray, Constants::$lastNameCharacters);
            return;
        }
    }

    private function validateEmails($em1, $em2) {
        if($em1 != $em2) {
            array_push($this->errorArray, Constants::$emailsDoNotMatch);
            return;
        }

        //Funkcja sprawdza czy email jest w poprawnej postaci
        if(!filter_var($em1, FILTER_VALIDATE_EMAIL)) {
            array_push($this->errorArray, Constants::$emailInvalid);
            return;
        }

        $sql = "SELECT email FROM users WHERE email = '$em1'";
        $checkEmailQuery = mysqli_query($this->con, $sql);
        //Sprawdza czy resultat z bazy danych zwrocil jakikolwiek wynik 
        if(mysqli_num_rows($checkEmailQuery) != 0) {
            array_push($this->errorArray, Constants::$emailTaken);
            return;
        }
    }

    private function validatePasswords($pw, $pw2) {
        if($pw != $pw2) {
            array_push($this->errorArray, Constants::$passwordsDoNotMatch);
            return;
        }

        //Sprawdzamy czy haslo nie pasuje do wzorca
        if(preg_match("/[^A-Za-z0-9]/", $pw)) {
            array_push($this->errorArray, Constants::$passwordsNotAlphanumeric);
            return;
        }

        if(strlen($pw) > 30 || strlen($pw) < 8) {
            array_push($this->errorArray, Constants::$passwordsCharacters);
            return;
        }
    }

    public function getCon() {
        return $this->con;
    }
        
}
?>