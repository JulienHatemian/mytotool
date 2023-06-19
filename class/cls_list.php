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

    public function getListById( int $id ) :object
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

    public function getTypeList() :array
    {
        $req = "
            SELECT *
            FROM type_list
        ";

        $sql = $this->pdo()->prepare( $req );

        $sql->execute();

        return $sql->fetchAll();
    }

    public function getTypeListById( int $idtype ) :array
    {
        $req = "
            SELECT *
            FROM type_list
            WHERE idtypelist = :idtype
        ";

        $sql = $this->pdo()->prepare( $req );
        $sql->bindValue( ':idtype', $idtype, PDO::PARAM_INT );

        $sql->execute();

        return $sql->fetchAll();
    }

    public function addList( string $libelle, string $description, int $type, int $user ) :void
    {
        $cls_check = new cls_check();

        $libelle = htmlspecialchars( $libelle );
        $description = htmlspecialchars( $description );
        $type = htmlspecialchars( $type );
        $user = htmlspecialchars( $user );

        $cls_check->checkAddList( $libelle, $description, $type, $user );

        
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
        $sql->bindValue( ':libelle', $libelle, PDO::PARAM_STR );
        $sql->bindValue( ':description', $description, PDO::PARAM_STR );
        $sql->bindValue( ':idtypelist', $type, PDO::PARAM_INT );
        $sql->bindValue( ':iduser', $user, PDO::PARAM_INT );

        $sql->execute();
    }

    public function addTask( string $libelle, string $description, int $user, int $list ) :void
    {
        $cls_check = new cls_check();
        
        $libelle = htmlspecialchars( $libelle );
        $description = htmlspecialchars( $description );
        $user = htmlspecialchars( $user );
        $list = htmlspecialchars( $list );

        $cls_check->checkAddTask( $libelle, $description, $user, $list );

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
        $sql->bindValue( ':libelle', $libelle, PDO::PARAM_STR );
        $sql->bindValue( ':description', $description, PDO::PARAM_STR );
        $sql->bindValue( ':idlist', $list, PDO::PARAM_INT );

        $sql->execute();
    }

    public function getTaskOnGoing( int $idlist ) :array{
        $req = "
            SELECT *
            FROM task
            WHERE idlist = :idlist
            AND complete = 0
            ORDER BY idtask
        ";

        $sql = $this->pdo()->prepare( $req );
        $sql->bindValue( ':idlist', $idlist, PDO::PARAM_INT );

        $sql->execute();

        return $sql->fetchAll();
    }

    public function getTaskComplete( int $idlist ) :array
    {
        $req = "
            SELECT *
            FROM task
            WHERE idlist = :idlist
            AND complete = 1
            ORDER BY idtask
        ";

        $sql = $this->pdo()->prepare( $req );
        $sql->bindValue( ':idlist', $idlist, PDO::PARAM_INT );

        $sql->execute();

        return $sql->fetchAll();
    }

    public function getTaskById( int $idtask ) :object{
        $req = "
            SELECT
                task.idtask,
                task.libelle AS libelle_task,
                task.description AS description_task,
                list.libelle AS libelle_list,
                list.description AS description_list,
                task.idlist,
                user.iduser,
                user.login as login,
                task.complete
            FROM task
            LEFT JOIN list ON list.idlist = task.idlist
            LEFT JOIN user ON user.iduser = list.iduser
            WHERE idtask = :idtask
        ";

        $sql = $this->pdo()->prepare( $req );
        $sql->bindValue( ':idtask', $idtask, PDO::PARAM_INT );

        $sql->execute();

        return $sql->fetch();
    }

    public function editTask( int $idtask, int $idlist, string $libelle, string $description ) :void {
        $cls_check = new cls_check();

        $idtask = htmlspecialchars( $idtask );
        $idlist = htmlspecialchars( $idlist );
        $libelle = htmlspecialchars( $libelle );
        $description = htmlspecialchars( $description );

        $cls_check->checkEditTask( $idtask, $idlist, $libelle, $description );

        $req = "
            UPDATE task
            SET libelle = :libelle,
                description = :description
            WHERE idtask = :idtask
        ";

        $sql = $this->pdo()->prepare( $req );
        $sql->bindValue( ':idtask', $idtask, PDO::PARAM_INT );
        $sql->bindValue( ':libelle', $libelle, PDO::PARAM_STR );
        $sql->bindValue( ':description', $description, PDO::PARAM_STR );

        $sql->execute();
    }

    public function deleteTask( int $idtask, int $idlist ) :void {
        $cls_check = new cls_check();

        $idtask = htmlspecialchars( $idtask );
        $idlist = htmlspecialchars( $idlist );
        $cls_check->checkDeleteTask( $idtask, $idlist );

        $req = "
            DELETE
            FROM task
            WHERE idtask = :idtask
            AND idlist = :idlist
        ";

        $sql = $this->pdo()->prepare( $req );
        $sql->bindValue( ':idtask', $idtask, PDO::PARAM_INT );
        $sql->bindValue( ':idlist', $idlist, PDO::PARAM_INT );

        $sql->execute();
    }

    public function updateStatus( int $idtask ) :void {
        $cls_check = new cls_check();

        $idtask = htmlspecialchars( $idtask );

        $cls_check->checkUpdateStatus( $idtask );

        if( $this->getStatus( $idtask ) === 1 ){
            $this->updateOngoing( $idtask );
        }
        else{
            $this->updateComplete( $idtask );
        }
        
    }

    private function updateComplete( int $id ) :void {
        $req = "
            UPDATE task
            SET complete = 1
            WHERE idtask = :idtask
            AND complete = 0
        ";

        $sql = $this->pdo()->prepare( $req );
        $sql->bindValue( ':idtask', $id, PDO::PARAM_INT );

        $sql->execute();
    }

    private function updateOngoing( int $id ) :void {
        $req = "
            UPDATE task
            SET complete = 0
            WHERE idtask = :idtask
            AND complete = 1
        ";

        $sql = $this->pdo()->prepare( $req );
        $sql->bindValue( ':idtask', $id, PDO::PARAM_INT );

        $sql->execute();
    }

    private function getStatus( int $idtask ) :int {
        $req = "
            SELECT complete
            FROM task
            WHERE idtask = :idtask
        ";

        $sql = $this->pdo()->prepare( $req );
        $sql->bindValue( ':idtask', $idtask, PDO::PARAM_INT );

        $sql->execute();
        $result = $sql->fetch();

        return $result->complete;
    }

    public function showModal( int $id ) :object
    {
        $cls_check = new cls_check();

        $cls_check->checkModal( $id );

        $result = $this->getTaskById( $id );

        return $result;
    }
}