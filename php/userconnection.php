<?php

$newconnection = new Connection();

class Connection
{
    private $server = "mysql:host=localhost;dbname=crmcsystem";
    private $user = "root";
    private $pass = "";
    private $options = array(
        PDO::ATTR_ERRMODE =>
        PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
    );
    protected $con;

    public function openConnection()
    {
        try {
            $this->con = new PDO(
                $this->server,
                $this->user,
                $this->pass,
                $this->options
            );
            return $this->con;
        } catch (PDOException $e) {
            echo "There's a problem in the connection: " . $e->getMessage();
        }
    }
    public function closeConnection()
    {
        $this->con = null;
    }
}
