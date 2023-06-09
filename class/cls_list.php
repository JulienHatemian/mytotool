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
                orderlist, 
                idtypelist,
                iduser
            )
            VALUES (
                :libelle,
                :description,
                :orderlist,
                :idtypelist,
                :iduser
            )
        ";

        $sql = $this->pdo()->prepare( $req );
        $sql->bindValue( ':libelle', $params[ 'libelle' ], PDO::PARAM_STR );
        $sql->bindValue( ':description', $params[ 'description' ], PDO::PARAM_STR );
        $sql->bindValue( ':orderlist', 1, PDO::PARAM_INT );
        $sql->bindValue( ':idtypelist', $params[ 'type' ], PDO::PARAM_INT );
        $sql->bindValue( ':iduser', $params[ 'user' ], PDO::PARAM_INT );

        $sql->execute();
    }
}