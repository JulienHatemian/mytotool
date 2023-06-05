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
    public function getListe( int $id ) :array
    {
        $req = "
            SELECT *
            FROM liste
            WHERE :id = 1
        ";

        $sql = $this->pdo()->prepare( $req );
        $sql->bindValue( ':id', $id, PDO::PARAM_INT );

        $sql->execute();

        return $sql->fetchAll();
    }
}