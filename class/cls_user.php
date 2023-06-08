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
    public function getConnected( array $params )
    {
        $cls_check = new cls_check();

        $params['login'] = htmlspecialchars( $params[ 'login' ] );
        $params['password'] = htmlspecialchars( $params[ 'password' ] );
        $cls_check->checkLogin( $params );
        
        session_start();

        $token = session_id().microtime().random_int( 0, 99999 );
        $token = hash( 'sha512', $token );

        $_SESSION[ 'profil' ] = [
            'login' => $params[ 'login' ],
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
    public function getLogin( string $params ) : array
    {
        $req = "
            SELECT *
            FROM user
            WHERE login = :login
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
        $sql->bindValue( ':password', password_hash( $params[ 'password' ], PASSWORD_BCRYPT ), PDO::PARAM_STR );

        $sql->execute();
    }

    public function join( $params ){
        $cls_check = new cls_check;
        $params[ 'login' ] = htmlspecialchars( $params[ 'login' ] );
        $params[ 'password' ] = htmlspecialchars( $params[ 'password' ] );
        $params[ 'password_confirmation' ] = htmlspecialchars( $params[ 'password_confirmation' ] );

        $cls_check->checkJoin( $params );

        $this->addUser( $params );
    }
}