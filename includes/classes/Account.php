<?php
class Account {

    private $errorArray;

    public function __construct() {
        $this->errorArray = array();
    }
    
    public function register($un, $fn, $ln, $em, $em2, $pw, $pw2) {
        $this->validateUsername($un);
        $this->validateFirstName($fn);
        $this->validateLastName($ln);
        $this->validateEmails($em, $em2);
        $this->validatePasswords($pw, $pw2);

        if(empty($this->errorArray)) {
            //Wstaw do bazy danych
            return true;
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

    private function validateUsername($un) {
        if(strlen($un) > 25 || strlen($un) < 5) {
            array_push($this->errorArray, Constants::$usernameCharacters);
            return;
        }

        //TODO: check if username exists
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

        //TODO: sprawdzic czy ten email nie zostal juz uzyty
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
        
}
?>