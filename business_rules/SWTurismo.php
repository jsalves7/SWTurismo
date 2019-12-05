<?php

require_once ('DB.php');

class SWTurismo extends DB
{
    public function signUp($name, $username, $password)
    {
        // sql query to sign in
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
        // sql query to login
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

            // create object user with data from db
            $user = new User($search['idUser'], $search['name'], $search['username'], $search['password']);

            // start session and put the object to a session variable so it can used on other pages
            session_start();
            $_SESSION['username'] = $user;

            //redirect page
            header("location:homepage.php");

        } else {
            // send an error message if there is no user with these credentials
            echo "<script> alert('O username e a password inseridos não correspondem a nenhuma conta') </script>";
        }
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

    public function listActivityAdmin($idAdmin = null)
    {
        if ($idAdmin) {
            // sql query to get the activities for the admin
            $sql = 'SELECT * FROM activity where idAdmin = :idAdmin';
            // know if there is an admin logged in
            $search = $this->query($sql, array('idAdmin' => $idAdmin));
        } else {
            // sql query to get the activities for the user
            $sql = 'SELECT * FROM activity';
            // put the sql query + execute query
            $search = $this->query($sql);
        }
        return $search;
    }

    public function listActivityUser($idUser)
    {
        // sql query to get a reservation
        $sql = 'SELECT * FROM reservation';
        // create array of fields to list the user activity
        $fields = array('idUser'=> $idUser);
        // put the fields and the sql query + execute query
        return $this->query($sql, $fields);
    }

    public function idActivity($idActivity)
    {
        // sql query to get the activity
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
        // sql query to list the images
        $sql = 'SELECT * FROM image where idImage = :idImage';
        // know if there is an image with this id
        $search = $this->query($sql, array("idImage" => $idImage));

        return $search[0]['name'].$search[0]['imagePath'];
    }

    public function commentActivity($comment, $idUser, $idActivity)
    {
        // set the date format
        $commentDate = date('Y-m-d');
        // sql query to insert a comment
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
        // sql query to list the comments
        $sql = $sql = "SELECT * FROM comments JOIN user USING (idUser) JOIN activity USING (idActivity);";
        return $this->query($sql);
    }

    public function search()
    {
        // verify if the search field is empty
        if (empty($_GET['search'])) {
            echo "<script> alert('Não existem resultados!') </script>";
            return [];
        } else {
            // verify if the search field is not empty
            if ($search = (!empty($_GET['search'])) ? $_GET['search'] : "") {
                // sql query to select activities by name
                $sql = 'SELECT * FROM activity WHERE name LIKE :search';
            } else {
                echo "<script> alert('Não existem resultados!') </script>";
                return [];
            }

            // create array of fields for the search field
            $fields = array('search' => $search."%");
            // put the fields and the sql query + execute query
            $searchQuery = $this->query($sql, $fields);

            $rows = count($searchQuery);
            if ($rows <= 0) {
                echo "<script> alert('Não existem resultados!') </script>";
                return [];
            } else {
                return $searchQuery;
            }
        }
    }

    // -------------------------- // -------------------------- //

    public function loginAdmin($username, $password)
    {
        //sql query
        $sql = 'SELECT * FROM admin WHERE username = :username AND password = :password';
        // create array of fields to log in
        $fields = array('username'=> $username, 'password' => hash('sha256', $password));
        // put the fields and the sql query + execute query
        $search = $this->query($sql, $fields);

        // verify if there is anyone with those credentials
        if (isset($search[0]['idAdmin'])) {
            $search = $search[0];

            // create object admin with data from db
            $admin = new Admin($search['idAdmin'], $search['name'], $search['username'], $search['password']);

            // start session and put the object to a session variable so it can used on other pages
            session_start();
            $_SESSION['admin'] = $admin;

            //redirect page
            header("location:admin.php");

        } else {
            // send an error message if there is no user with these credentials
            echo "<script> alert('Não existe nenhuma conta de administrador com essas credenciais') </script>";
        }
    }

    public function isAdminLoggedIn()
    {
        session_start();

        // verify if there is admin logged in
        if (isset($_SESSION['admin'])) {
            header("location:admin.php");
        }
    }

    public function isAdminLoggedOff()
    {
        session_start();

        // verify if there is admin logged in
        if (isset($_SESSION['admin'])) {
            header("location:index.php");
        }
    }

    public function addActivity($name, $desc, $price, $idAdmin, $img)
    {
        // sql query to insert an image
        $sql = 'INSERT INTO image (name, imagePath) VALUES (:name, "img/")';
        // strip whitespace (or other characters) from the string
        $this->query($sql, array('name' => trim($img, " ")));
        // sql query to select the image
        $sql="SELECT * FROM image ORDER BY idImage DESC LIMIT 1";
        // put the sql query + execute query
        $img = $this->query($sql);

        // sql query to insert an activity
        $sql = "INSERT INTO activity (name, desc, price, idAdmin, idImage) VALUES (:name, :desc, :price, :idAdmin, :img)";
        // create array of fields for the activity
        $fields = array(
            'name' => $name,
            'desc' => $desc,
            'price' => $price,
            'idAdmin' => $idAdmin,
            'img' => $img[0]['idImage']);

        // put the fields and the sql query + execute query
        $this->query($sql, $fields);
    }

    public function deleteActivity($id)
    {
        // sql query to delete an activity
        $sql = 'DELETE FROM activity WHERE idActivity = :idActivity';
        // put the sql query + execute query
        $this->query($sql, array('idActivity' => $id));
    }

    public function updateActivity($idActivity, $name, $desc, $price, $idAdmin)
    {
        //TODO: implement update img

        // sql query to update an activity
        $sql = "UPDATE activity SET name = :name, desc = :desc, price = :price, idAdmin = :idAdmin WHERE idActivity = :idActivity";
        // create array of fields for the activity
        $fields = array(
            'name' => $name,
            'desc' => $desc,
            'price' => $price,
            'idAdmin' => $idAdmin,
            'idActivity' => $idActivity);

        //var_dump($fields);

        // put the fields and the sql query + execute query
        $this->query($sql, $fields);
    }

    public function deleteReservation($idUser, $idActivity)
    {
        // sql query to delete a reservation
        $sql = 'DELETE FROM reservation WHERE idUser = :idUser AND idActivity = :idActivity';
        // put the sql query + execute query
        $this->query($sql, array('idUser' => $idUser, 'idActivity' => $idActivity));
    }

    public function countActivity()
    {
        // sql query to count the activities
        $sql = 'SELECT COUNT(*) FROM activity';
        // put the sql query + execute query
        $result = $this->query($sql);
        return $result[0]['COUNT(*)'];

        //var_dump($result);
    }

    public function countUser()
    {
        // sql query to count the activities
        $sql = 'SELECT COUNT(*) FROM user';
        // put the sql query + execute query
        $result = $this->query($sql);
        return $result[0]['COUNT(*)'];

        //var_dump($result);
    }

    public function listReservationsAdmin($idActivity)
    {
        // sql query to list the reservations
        $sql = "SELECT * from reservation JOIN creditCard USING (idUser) where idActivity = :idActivity";
        // put the fields and the sql query + execute query
        $fields = array('idActivity' => $idActivity);
        return $this->query($sql, $fields);
    }

    public function changeReservationState($state, $idActivity, $idUser)
    {
        // sql query to update the reservation state
        $sql = "UPDATE reservation SET state = :state WHERE idActivity = :idActivity AND idUser =:idUser";
        // create array of fields for the change state of the reservation
        $fields = array(
            'state' => $state,
            'idActivity' => $idActivity,
            'idUser' => $idUser);

        //var_dump($fields);

        // put the fields and the sql query + execute query
        $this->query($sql, $fields);
    }
}
