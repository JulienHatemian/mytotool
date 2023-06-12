<?php


class cls_list
    extends cls_core
{
    /**
     * Récupérer le tableau des listes
     *
     * @param integer $id
     * @return array
     */
    public function getListByUser( int $id ) :array
    {
        $req = "
            SELECT *
            FROM list
            LEFT JOIN user
            ON list.iduser = user.iduser
            WHERE user.iduser = :id
        ";

        $sql = $this->pdo()->prepare( $req );
        $sql->bindValue( ':id', $id, PDO::PARAM_INT );

        $sql->execute();

        return $sql->fetchAll();
    }

    public function getListById( int $id )
    {
        $cls_user = new cls_user();
        $user = $cls_user->getLogin( $_SESSION[ 'profil' ][ 'login' ] );

        $req = "
            SELECT *
            FROM list
            WHERE idlist = :id
            AND iduser = :user
        ";

        $sql = $this->pdo()->prepare( $req );
        $sql->bindValue( ':id', $id, PDO::PARAM_INT );
        $sql->bindValue( ':user', $user[0]->iduser, PDO::PARAM_INT );

        $sql->execute();

        return $sql->fetch();
    }

    public function getTypeList(){
        $req = "
            SELECT *
            FROM type_list
        ";

        $sql = $this->pdo()->prepare( $req );

        $sql->execute();

        return $sql->fetchAll();
    }

    public function addList( $params ){
        $cls_check = new cls_check();

        $params[ 'libelle' ] = htmlspecialchars( $params[ 'libelle' ] );
        $params[ 'description' ] = htmlspecialchars( $params[ 'description' ] );
        $params[ 'type' ] = htmlspecialchars( $params[ 'type' ] );
        $params[ 'user' ] = htmlspecialchars( $params[ 'user' ] );
        
        $cls_check->checkAddList( $params );

        $req = "
            INSERT INTO list (
                libelle,
                description,
                idtypelist,
                iduser
            )
            VALUES (
                :libelle,
                :description,
                :idtypelist,
                :iduser
            )
        ";

        $sql = $this->pdo()->prepare( $req );
        $sql->bindValue( ':libelle', $params[ 'libelle' ], PDO::PARAM_STR );
        $sql->bindValue( ':description', $params[ 'description' ], PDO::PARAM_STR );
        $sql->bindValue( ':idtypelist', $params[ 'type' ], PDO::PARAM_INT );
        $sql->bindValue( ':iduser', $params[ 'user' ], PDO::PARAM_INT );

        $sql->execute();
    }

    public function addTask( array $params ) :void
    {
        $cls_check = new cls_check();
        
        $params[ 'libelle' ] = htmlspecialchars( $params[ 'libelle' ] );
        $params[ 'description' ] = htmlspecialchars( $params[ 'description' ] );
        $params[ 'user' ] = htmlspecialchars( $params[ 'user' ] );
        $params[ 'list' ] = htmlspecialchars( $params[ 'list' ] );

        $cls_check->checkAddTask( $params );

        $req = "
            INSERT INTO task (
                libelle,
                description,
                idlist
            )
            VALUES (
                :libelle,
                :description,
                :idlist 
            )
        ";

        $sql = $this->pdo()->prepare( $req );
        $sql->bindValue( ':libelle', $params[ 'libelle' ], PDO::PARAM_STR );
        $sql->bindValue( ':description', $params[ 'description' ], PDO::PARAM_STR );
        $sql->bindValue( ':idlist', $params[ 'list' ], PDO::PARAM_INT );

        $sql->execute();
    }

    public function getTaskOnGoing( $id ){
        $req = "
            SELECT *
            FROM task
            WHERE idlist = :id
            AND complete = 0
            ORDER BY idtask
        ";

        $sql = $this->pdo()->prepare( $req );
        $sql->bindValue( ':id', $id, PDO::PARAM_INT );

        $sql->execute();

        return $sql->fetchAll();
    }

    public function getTaskComplete( $id ){
        $req = "
            SELECT *
            FROM task
            WHERE idlist = :id
            AND complete = 1
            ORDER BY idtask
        ";

        $sql = $this->pdo()->prepare( $req );
        $sql->bindValue( ':id', $id, PDO::PARAM_INT );

        $sql->execute();

        return $sql->fetchAll();
    }
}