<?php

require_once ('DB.php');

class SWTurismo extends DB
{
    public function signUp($name, $username, $password)
    {
        // sql query
        $sql = "INSERT INTO user (name, username, password) VALUES (:name, :username, :password)";

        // create array of fields for query
        $fields = array(
            'username'=> $username,
            'password' => hash('sha256', $password),
            'name'=>$name);

        // put the fields and the sql query + execute query
        $this->query($sql, $fields);

        // login using the info from the signUp
        $this->loginUser($username, $password);
    }

    public function loginUser($username, $password)
    {
        // sql query
        $sql = 'SELECT * FROM user WHERE username = :username  AND password = :password';

        // create array of fields to log in
        $fields = array(
            'username'=> $username,
            'password' => hash('sha256', $password));

        // put the fields and the sql query + execute query
        $search = $this->query($sql, $fields);

        // verify if there is anyone with those credentials
        if(isset($search[0]['idUser'])){
            $search = $search[0];

            // create object user
            $user = new User($search['idUser'], $search['name'], $search['username'], $search['password']);

            // start session and put the object to a session variable so it can used on other pages
            session_start();
            $_SESSION['username'] = $user;

            // direction to login
            header("location:homepage.php");

        } else {
            // send an error message if there is no user with these credentials
            echo "<script> alert('O username e a password inseridos não correspondem a nenhuma conta') </script>";
        }
    }

    public function listActivityAdmin($idAdmin = null)
    {
        if ($idAdmin) {
            // sql query
            $sql = 'SELECT * FROM activity where idAdmin = :idAdmin';
            // know if there is an admin logged in
            $search = $this->query($sql, array('idAdmin' => $idAdmin));
        } else {
            // sql query
            $sql = 'SELECT * FROM activity';
            // put the sql query + execute query
            $search = $this->query($sql);
        }
        return $search;
    }

    public function listActivityUser($idUser)
    {
        // sql query
        $sql = 'SELECT * FROM reservation';
        // create array of fields to list the user activity
        $fields = array('idUser'=> $idUser);
        // put the fields and the sql query + execute query
        return $this->query($sql, $fields);
    }

    public function idActivity($idActivity)
    {
        // sql query
        $sql = 'SELECT * FROM activity where idActivity = :idActivity';
        // get the activity id
        $search = $this->query($sql, array("idActivity" => $idActivity));
        // check if the activity exists
        if (!isset($search[0])) {
            return null;
        }
        return $search[0];
    }

    public function reserveActivity($idUser, $idActivity, $reservationDate, $name, $cardNumber, $expiry, $cardType, $securityCode)
    {
        // sql query for reservations
        $sqlReservation = "INSERT INTO reservation (idUser, idActivity, reservationDate, state) VALUES (:idUser, :idActivity, :reservationDate, :state)";
        // create array of fields for reservations
        $fieldsReservation = array(
            'idUser' => $idUser,
            'idActivity' => $idActivity,
            'reservationDate' => $reservationDate,
            'state' => 'reservada');

        // put the fields and the sql query + execute query
        $this->query($sqlReservation, $fieldsReservation);

        // sql query for creditCard
        $sqlCreditCard = "INSERT INTO creditCard (name, cardNumber, expiry, cardType, securityCode, idUser) VALUES (:name, :cardNumber, :expiry, :cardType, :securityCode, :idUser)";

        // create array of fields for the credit card
        $fieldsCreditCard = array(
            'name' => $name,
            'cardNumber' => $cardNumber,
            'expiry' => $expiry,
            'cardType' => $cardType,
            'securityCode' => $securityCode);

        // aes encrypt/decrypt reference: https://odan.github.io/2017/08/10/aes-256-encryption-and-decryption-in-php-and-csharp.html

        $password = '3sc3RLrpd17';
        $method = 'aes-256-cbc';

        // password must be exact 32 chars (256 bit)
        $password = substr(hash('sha256', $password, true), 0, 32);

        // IV must be exact 16 chars (128 bit)
        $iv = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);

        // getting each key/value from the fieldsCreditCard array and encoding it
        // OPENSSL_RAW_DATA -> tells the openssl_encrypt to return the cipherText in rawData
        foreach ($fieldsCreditCard as $key => $value){
            $fieldsCreditCard[$key] = base64_encode(openssl_encrypt($value, $method, $password, OPENSSL_RAW_DATA, $iv));
        }

        // reference a credit card to a user
        $fieldsCreditCard['idUser'] = $idUser;

        // put the fields and the sql query + execute query
        $this->query($sqlCreditCard, $fieldsCreditCard);
    }

    public function activityImage($idImage)
    {
        // sql query
        $sql = 'SELECT * FROM image where idImage = :idImage';
        // know if there is an image with this id
        $search = $this->query($sql, array("idImage" => $idImage));

        return $search[0]['name'].$search[0]['imagePath'];
    }

    public function commentActivity($comment, $idUser, $idActivity)
    {
        // set the date format
        $commentDate = date('Y-m-d');
        // sql query
        $sql = "INSERT INTO comment (comment, commentDate, idUser, idActivity) VALUES (:comment, :commentDate, :idUser, :idActivity)";
        // create array of fields for comments
        $fields = array(
            'comment' => $comment,
            'commentDate' => $commentDate,
            'idUser' => $idUser,
            'idActivity' => $idActivity);
        // put the fields and the sql query + execute query
        $this->query($sql, $fields);
    }

    public function listComments()
    {
        // sql query
        $sql = $sql = "SELECT * FROM comments JOIN user USING (idUser) JOIN activity USING (idActivity);";
        return $this->query($sql);
    }

    public function isUserLoggedIn()
    {
        session_start();

        // verify if there is user logged in
        if (isset($_SESSION['username'])) {
            header("location:homepage.php");
        }
    }

    public function isUserLoggedOff()
    {
        session_start();

        // verify if there is user logged in
        if (!isset($_SESSION['username'])) {
            header("location:index.php");
        }
    }

    // -------------------------- // -------------------------- //

    public function isAdminLoggedIn()
    {

    }
}
