<?php

class User
{
    // user attributes
    private $idUser;
    private $name;
    private $username;
    private $password;

    public function __construct($idUser, $name, $username, $password)
    {
        $this->idUser = $idUser;
        $this->name = $name;
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * function to get the user id
     *
     * @return mixed
     */
    public function idUser()
    {
        return $this->idUser;
    }

    /**
     * function to get the user name
     *
     * @return mixed
     */
    public function nameUser()
    {
        return $this->name;
    }

    /**
     * function to do the user logout
     */
    public function logout()
    {
        session_destroy();
        header('');
    }
}
