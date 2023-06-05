<?php

class cls_core
{
    public $_pdo;

    public function __construct()
    {
        $this->_pdo = $this->pdo();
    }

    public function pdo()
    {
        try
        {
            $pdo = new PDO( "mysql:host=localhost; dbname=mytotool; charset=utf8mb4;", 'root', '' );
            $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
            $pdo->setAttribute( PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ );
            $pdo->setAttribute( PDO::ATTR_EMULATE_PREPARES, false );
        }
        catch( PDOException $e )
        {
            echo "Erreur: " . $e->getMessage();
            exit();
        }

        return $pdo;
    }
}