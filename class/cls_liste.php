<?php


class cls_liste
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
}