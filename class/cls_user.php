<?php


class cls_user
    extends cls_core
{
    public function __construct()
    {
        // if( $this->isConnected() === false ){
        //     header('Location: connexion.php');
        // }
    }
    /**
     * Check si connectée
     * @return bool
     */
    public function isConnected() :bool
    {
        if( isset( $_SESSION['login'] ) ){
            return true;
        }
        else{
            return false;
        }
    }

    /**
     * Se connecter
     *
     * @param array $params
     * @return array
     */
    public function getConnected( array $params )
    {
        $cls_check = new cls_check();

        $cls_check->checkLogin( $params );
        // var_dump( $this->loginExist( $params['login'] ) );
    }

    /**
     * Check si login exist
     *
     * @param string $params
     * @return array
     */
    public function loginExist( string $params ) : array
    {
        $req = "
            SELECT user.iduser
            FROM user
            WHERE user.login = :login
        ";

        $sql = $this->pdo()->prepare( $req );
        $sql->bindValue( ':login', $params, PDO::PARAM_STR );

        $sql->execute();

        return $sql->fetchAll();
    }

    public function addUser( $params ){
        $req = "
            INSERT INTO user (
                login, 
                password
            )
            VALUES (
                :login,
                :password
            )
        ";

        $sql = $this->pdo()->prepare( $req );
        $sql->bindValue( ':login', $params[ 'login' ], PDO::PARAM_STR );
        $sql->bindValue( ':password', $params[ 'password' ], PDO::PARAM_STR );

        $sql->execute();
    }
}