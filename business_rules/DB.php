<?php

class DB extends PDO
{
    // config attributes
    private $driver;
    private $host;
    private $dbname;
    private $port;
    private $user;
    private $pw;

    // db attributes
    private $conn;
    private $stmts;
    private $error;

    public function __construct($configFile)
    {
        // get data from config file
        $config = parse_ini_file($configFile);

        $this->driver = $config['driver'];
        $this->host = $config['host'];
        $this->port = $config['port'];
        $this->dbname = $config['dbname'];
        $this->user = $config['user'];
        $this->pw = $config['pw'];

        // dsn creation
        $dsn = $this->driver . ': host=' . $this->host . '; port=' . $this->port . '; dbname=' . $this->dbname;

        // db connection creation
        try {
            $this->conn = new PDO($dsn, $this->user, $this->pw);
        } catch (PDOException $e) {
            echo $e->getMessage();
            $this->conn = null;
        }
    }

    public function query($stm, $parameters = [], $singleResult = false)
    {
        // sanitizing strings

        if (is_string($stm) && $stm !== "" && is_array($parameters) && is_bool($singleResult)) {

            try {
                $this->stmts = $this->conn->prepare($stm);

                foreach ($parameters as $parameter => $value) {
                    if (is_string($value))
                        $type = PDO::PARAM_STR;
                    elseif (is_int($value))
                        $type = PDO::PARAM_INT;
                    elseif (is_bool($value))
                        $type = PDO::PARAM_BOOL;
                    else
                        $type = PDO::PARAM_NULL;

                    $value = filter_var($value, FILTER_SANITIZE_STRING);

                    $this->stmts->bindValue($parameter, $value, $type);
                }
                $this->stmts->execute();

                $singleResult === true
                    ? $results = $this->stmts->fetch(PDO::FETCH_ASSOC)
                    : $results = $this->stmts->fetchAll(PDO::FETCH_ASSOC);

                return $results;

            } catch (PDOException $e) {
                $this->error = $e->getMessage();
            }
        } else {
            $this->error = "Parâmetros Inválidos";
            return null;
        }
    }
}