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
            WHERE idlist = :id
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
}