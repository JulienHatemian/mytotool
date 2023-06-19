<?php


class cls_user
    extends cls_core
{
    /**
     * Check si connectée
     * @return bool
     */
    public function isConnected() :bool
    {
        if( isset( $_SESSION['profil'] ) ){
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
    // public function getConnected( array $params )
    public function getConnected( string $login, string $password,  )
    {
        $cls_check = new cls_check();

        $login = htmlspecialchars( $login );
        $password = htmlspecialchars( $password );
        $cls_check->checkLogin( $login, $password );
        
        session_start();

        $token = session_id().microtime().random_int( 0, 99999 );
        $token = hash( 'sha512', $token );

        $_SESSION[ 'profil' ] = [
            'login' => $login,
            'role' => 'user',
            'token' => $token
        ];
    }

    /**
     * Check si login exist
     *
     * @param string $params
     * @return array
     */
    public function getLogin( string $login ) : array
    {
        $req = "
            SELECT *
            FROM user
            WHERE login = :login
        ";

        $sql = $this->pdo()->prepare( $req );
        $sql->bindValue( ':login', $login, PDO::PARAM_STR );

        $sql->execute();

        return $sql->fetchAll();
    }

    public function addUser( string $login, string $password ) :void
    {
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
        $sql->bindValue( ':login', $login, PDO::PARAM_STR );
        $sql->bindValue( ':password', password_hash( $password, PASSWORD_BCRYPT ), PDO::PARAM_STR );

        $sql->execute();
    }

    public function join( string $login, string $password, string $passwordConfirmation ){
        $cls_check = new cls_check;
        $login = htmlspecialchars( $login );
        $password = htmlspecialchars( $password );
        $passwordConfirmation = htmlspecialchars( $passwordConfirmation );

        $cls_check->checkJoin( $login, $password, $passwordConfirmation );

        $this->addUser( $login, $password );
    }
}