<?php

class cls_list
    extends cls_core
{
    /**
     * Récupérer le tableau des listes
     * @param int $iduser
     * 
     * @return array
     */
    public function getListByUser( int $iduser ) :array
    {
        $req = "
            SELECT *
            FROM list
            LEFT JOIN user
            ON list.iduser = user.iduser
            WHERE user.iduser = :iduser
        ";

        $sql = $this->pdo()->prepare( $req );
        $sql->bindValue( ':iduser', $iduser, PDO::PARAM_INT );

        $sql->execute();

        return $sql->fetchAll();
    }

    /**
     * Récupérer la liste en objet en fonction de l'id
     * @param int $id
     * 
     * @return object|bool
     */
    public function getListById( int $id ) :object|bool
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

    /**
     * Récupérer le tableau des différents types de listes
     * 
     * @return array
     */
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

    /**
     * Récupérer le type de liste en fonction de son id
     * @param int $idtype
     * 
     * @return array
     */
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

    /**
     * Récupérer le type de liste en fonction de son id
     * @param string $libelle
     * @param string $description
     * @param int $type
     * @param int $user
     * 
     * @return void
     */
    public function addList( string $libelle, string $description, int $type, int $user ) :void
    {
        $cls_check = new cls_check();

        $libelle = htmlspecialchars( trim( $libelle ) );
        $description = htmlspecialchars( trim( $description ) );
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

    /**
     * Ajouter une nouvelle tâche
     * @param string $libelle
     * @param string $description
     * @param int $user
     * @param int $list
     * 
     * @return void
     */
    public function addTask( string $libelle, string $description, int $user, int $list ) :void
    {
        $cls_check = new cls_check();
        
        $libelle = htmlspecialchars( trim( $libelle ) );
        $description = htmlspecialchars( trim( $description ) );
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

    /**
     * Récupère les tâches avec l'état "En cours"
     * @param int $idlist
     * 
     * @return array
     */
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

    /**
     * Récupère les tâches avec l'état "Complété"
     * @param int $idlist
     * 
     * @return array
     */
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

    /**
     * Récupère l'objet de la tâche en fonction de l'Id de la tâche
     * @param int $idtask
     * 
     * @return object|bool
     */
    public function getTaskById( int $idtask ) :object|bool{
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

    /**
     * Récupère l'objet de la tâche en fonction de l'Id de la tâche
     * @param int $idtask
     * @param int $idlist
     * @param string $libelle
     * @param string $description
     * 
     * @return void
     */
    public function editTask( int $idtask, int $idlist, string $libelle, string $description ) :void {
        $cls_check = new cls_check();

        $idtask = htmlspecialchars( $idtask );
        $idlist = htmlspecialchars( $idlist );
        $libelle = htmlspecialchars( trim( $libelle ) );
        $description = htmlspecialchars( trim( $description ) );

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

    /**
     * Supprimer une tâche
     * @param int $idtask
     * @param int $idlist
     * 
     * @return void
     */
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

    /**
     * Modifie le statut d'une tâche (En "complété" ou "en cours")
     * @param int $idtask
     * 
     * @return void
     */
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

    /**
     * Passer une tâche à l'état "Complété"
     * @param int $idtask
     * 
     * @return void
     */
    private function updateComplete( int $idtask ) :void {
        $req = "
            UPDATE task
            SET complete = 1
            WHERE idtask = :idtask
            AND complete = 0
        ";

        $sql = $this->pdo()->prepare( $req );
        $sql->bindValue( ':idtask', $idtask, PDO::PARAM_INT );

        $sql->execute();
    }

    /**
     * Passer une tâche à l'état "En cours"
     * @param int $idtask
     * 
     * @return void
     */
    private function updateOngoing( int $idtask ) :void {
        $req = "
            UPDATE task
            SET complete = 0
            WHERE idtask = :idtask
            AND complete = 1
        ";

        $sql = $this->pdo()->prepare( $req );
        $sql->bindValue( ':idtask', $idtask, PDO::PARAM_INT );

        $sql->execute();
    }

    /**
     * Récupère l'état d'une tâche
     * @param int $idtask
     * 
     * @return int
     */
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

    /**
     * Récupère les données pour un modal sur la page des tâches
     * @param int $idtask
     * 
     * @return object|bool
     */
    public function showModal( int $idtask ) :object|bool
    {
        $cls_check = new cls_check();

        $cls_check->checkModalTask( $idtask );

        $result = $this->getTaskById( $idtask );

        return $result;
    }

    /**
     * Modifier les données d'une liste
     * @param int $idlist
     * @param string $libelle
     * @param string $description
     * 
     * @return void
     */
    public function editList( int $idlist, string $libelle, string $description ):void
    {
        $cls_check = new cls_check();

        $idlist = htmlspecialchars( $idlist );
        $libelle = htmlspecialchars( trim( $libelle ) );
        $description = htmlspecialchars( trim( $description ) );

        $cls_check->checkEditList( $idlist, $libelle, $description );

        $req = "
            UPDATE list
            SET libelle = :libelle,
                description = :description
            WHERE idlist = :idlist
        ";

        $sql = $this->pdo()->prepare( $req );
        $sql->bindValue( ':idlist', $idlist, PDO::PARAM_INT );
        $sql->bindValue( ':libelle', $libelle, PDO::PARAM_STR );
        $sql->bindValue( ':description', $description, PDO::PARAM_STR );

        $sql->execute();

    }

    /**
     * Supprimer une liste
     * @param int $idlist
     * 
     * @return void
     */
    public function deleteList( int $idlist ):void
    {
        $cls_check = new cls_check();
        $idlist = htmlspecialchars( $idlist );

        $cls_check->checkDeleteList( $idlist );

        //CLEAR TASK
        $this->clearTask( $idlist );

        $req = "
            DELETE
            FROM list
            WHERE idlist = :idlist
        ";

        $sql = $this->pdo()->prepare( $req );
        $sql->bindValue( ':idlist', $idlist, PDO::PARAM_INT );

        $sql->execute();
    }

    /**
     * Supprimer les tâche d'une liste en fonction de son Id
     * @param int $idlist
     * 
     * @return void
     */
    private function clearTask( int $idlist ):void
    {
        $req = "
            DELETE
            FROM task
            WHERE idlist = :idlist
        ";

        $sql = $this->pdo()->prepare( $req );
        $sql->bindValue( ':idlist', $idlist, PDO::PARAM_INT );

        $sql->execute();
    }
}