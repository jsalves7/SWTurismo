<?php

class Admin
{
    // admin attributes
    private $idAdmin;
    private $name;
    private $username;
    private $password;

    public function __construct($idAdmin, $name, $username, $password)
    {
        $this->idAdmin = $idAdmin;
        $this->name = $name;
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * function to get the admin id
     *
     * @return mixed
     */
    public function idAdmin()
    {
        return $this->idAdmin;
    }

    /**
     * function to get the admin name
     *
     * @return mixed
     */
    public function nameAdmin()
    {
        return $this->name;
    }

    /**
     * function to do the admin logout
     */
    public function logout()
    {
        session_destroy();
        header('');
    }
}
