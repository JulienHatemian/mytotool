<?php

class cls_check
    extends cls_core
{
    /**
     * Check le passage des paramètres lors du login
     * @param string $login
     * @param string $password
     * 
     * @return void
     */
    public function checkLogin( string $login, string $password ) :void
    {
        $cls_user = new cls_user();
        $user = $cls_user->getLogin( $login );

        if( empty( $login ) || empty( $password ) || !$login || !$password || count( $cls_user->getLogin( $login ) ) === 0 || !password_verify( $password, $user[ 0 ]->password ) ){

            throw new Exception( 'Identifiant ou mot de passe invalides !' );
        }
    }

    /**
     * Check le passage des paramètres lors de l'inscription
     * @param string $login
     * @param string $password
     * @param string $passwordconfirmation
     * 
     * @return void
     */
    public function checkJoin( string $login, string $password, string $passwordconfirmation ) :void
    {
        $cls_user = new cls_user();

        if( count( $cls_user->getLogin( $login ) ) > 0 ){
            throw new Exception( 'Login déjà existant' );
        }

        if( !$login || !$password || !$passwordconfirmation ){
            throw new Exception( 'Veuillez compléter les champs requis' );
        }

        if ( !filter_var( $login, FILTER_VALIDATE_EMAIL ) && strlen( $login ) > 255 ) {
            throw new Exception( 'Veuillez rentrer un format de mail valide et avec 255 caractères maximum.' );
          }

        if ( ( strlen( $password ) < 8 || strlen( $password ) > 255 ) || !preg_match("/\d/", $password ) || !preg_match("/[A-Z]/", $password ) || !preg_match("/[a-z]/", $password ) ) {
            throw new Exception( 'Votre mot de passe doit contenir au moins 8 caractères, une minuscule, une majuscule, un chiffre.' );
        }

        if( $password != $passwordconfirmation ){
            throw new Exception( 'Les mots de passes de confirmation ne sont pas identiques.' );
        }
    }

    /**
     * Check les paramètres lors de l'ajout d'une liste
     * @param string $libelle
     * @param string $description
     * @param int $idtype
     * @param int $iduser
     * 
     * @return void
     */
    public function checkAddList( string $libelle, string $description, int $idtype, int $iduser ) :void
    {
        $cls_user = new cls_user();
        $cls_list = new cls_list();

        if( $cls_user->isConnected() === false ){
            throw new Exception( 'Non-connecté' );
        }

        $user = $cls_user->getLogin( $_SESSION[ 'profil' ][ 'login' ] );

        if( $iduser != $user[ 0 ]->iduser ){
            throw new Exception( 'Utilisateur non-valide.' );
        }

        if( count( $cls_list->getListByUser( $iduser ) ) == 30 ){
            throw new Exception( 'Le nombre maximal (30) de listes a été atteint.' );
        }

        if( empty( $libelle ) || !$libelle ){
            throw new Exception( 'Libelle non-valide' );
        }

        if( strlen( $libelle ) > 30 ){
            throw new Exception( 'Le libelle ne doit pas contenir plus de 30 caractères' );
        }

        if( empty( $description ) || !$description ){
            throw new Exception( 'Description non-valide' );
        }

        if( strlen( $description ) > 255 ){
            throw new Exception( 'Le description ne doit pas contenir plus de 255 caractères' );
        }

        if( count( $cls_list->getTypeListById( $idtype ) ) == 0 ){
            throw new Exception( 'Type non-valide.' );
        }
    }

    /**
     * Check les paramètres lors de l'ajout d'une tâche
     * @param string $libelle
     * @param string $description
     * @param int $iduser
     * @param int $list
     * 
     * @return void
     */
    public function checkAddTask( string $libelle, string $description, int $iduser, int $list ) :void
    {
        $cls_user = new cls_user();
        $cls_list = new cls_list();

        if( $cls_user->isConnected() === false ){
            throw new Exception( 'Non-connecté' );
        }

        $user = $cls_user->getLogin( $_SESSION[ 'profil' ][ 'login' ] );
        if( $iduser != $user[ 0 ]->iduser ){
            throw new Exception( 'Utilisateur non-valide.' );
        }

        if( $cls_list->getListById( $list ) === false ){
            throw new Exception( 'Liste non-valides' );
            header( 'Location: ../index.php' );
        }

        if( empty( $libelle ) ){
            throw new Exception( 'Nom de tâche non-valide' );
        }

        if( strlen( $libelle ) > 70 ){
            throw new Exception( 'Le nom de la tâche ne doit pas exéder les 70 caractères.' );
        }
        
        if( strlen( $description ) > 255 ){
            throw new Exception( 'La description ne doit pas exéder les 255 caractères.' );
        }
    }

    /**
     * Check les paramètres lors de l'ouverture d'un modal dans la page des tâches
     * @param int $id
     * 
     * @return void
     */
    public function checkModalTask( int $id ) :void
    {
        $cls_list = new cls_list();
        $cls_user = new cls_user();

        if( $cls_user->isConnected() === false ){
            throw new Exception( 'Non-connecté' );
        }

        $task = $cls_list->getTaskById( $id );
        if( $task === null || $task->login != $_SESSION[ 'profil' ][ 'login' ] ){
            throw new Exception( 'Tâche non-valides' );
            header( 'Location: ../index.php' );
        }
    }

    /**
     * Check les paramètres lors de l'édition d'une tâche
     * @param int $idtask
     * @param int $idlist
     * @param string $libelle
     * @param string $description
     * 
     * @return void
     */
    public function checkEditTask( int $idtask, int $idlist, string $libelle, string $description ) :void
    {
        $cls_list = new cls_list();
        $cls_user = new cls_user();

        if( $cls_user->isConnected() === false ){
            throw new Exception( 'Non-connecté' );
        }

        $task = $cls_list->getTaskById( $idtask );

        if( $task === null || $task->login != $_SESSION[ 'profil' ][ 'login' ] ){
            throw new Exception( 'Utilisateur non-valide.' );
        }

        if( $task->idlist != $idlist ){
            throw new Exception( 'Liste inconnue.' );
            header( 'Location: ../index.php' );
        }

        if( empty( $libelle ) || !$libelle ){
            throw new Exception( 'Données manquantes' );
        }

        if( strlen( $libelle ) > 70 ){
            throw new Exception( 'Le libelle ne doit pas faire plus de 80 caractères.' );
        }

        if( strlen( $description ) > 255 ){
            throw new Exception( 'Le description ne doit pas faire plus de 255 caractères.' );
        }
    }

    /**
     * Check les paramètres lors de l'édition d'une liste
     * @param int $idlist
     * @param string $libelle
     * @param string $description

     * @return void
     */
    public function checkEditList( int $idlist, string $libelle, string $description ):void
    {
        $cls_list = new cls_list();
        $cls_user = new cls_user();

        if( $cls_user->isConnected() === false ){
            throw new Exception( 'Non-connecté' );
        }

        $user = $cls_user->getLogin( $_SESSION[ 'profil' ][ 'login' ] );
        $list = $cls_list->getListById( $idlist );

        if( $cls_user->isConnected() === false ){
            throw new Exception( 'Utilisateur non-valide.' );
            header( 'Location: ../index.php' );
        }

        if( $list === null || $list->iduser != $user[ 0 ]->iduser ){
            throw new Exception( 'Liste inconnue.' );
            header( 'Location: ../index.php' );
        }

        if( empty( $libelle ) || !$libelle || empty( $description ) || !$description || !$idlist ){
            throw new Exception( 'Données manquantes' );
        }

        if( strlen( $libelle ) > 30 ){
            throw new Exception( 'Le libelle ne doit pas faire plus de 30 caractères.' );
        }

        if( strlen( $description ) > 255 ){
            throw new Exception( 'Le description ne doit pas faire plus de 255 caractères.' );
        }
    }

    /**
     * Check les paramètres lors de la suppression d'une liste
     * @param int $idlist

     * @return void
     */
    public function checkDeleteList( int $idlist ):void
    {
        $cls_list = new cls_list();
        $cls_user = new cls_user();

        if( $cls_user->isConnected() === false ){
            throw new Exception( 'Non-connecté' );
        }

        $user = $cls_user->getLogin( $_SESSION[ 'profil' ][ 'login' ] );
        $list = $cls_list->getListById( $idlist );

        if( !isset( $idlist ) ){
            throw new Exception( 'Données manquantes.' );
            header( 'Location: ../index.php' );
        }

        if( $cls_user->isConnected() === false ){
            throw new Exception( 'Utilisateur non-valide.' );
            header( 'Location: ../index.php' );
        }

        if( $list === null || $list->iduser != $user[ 0 ]->iduser ){
            throw new Exception( 'Liste inconnue.' );
            header( 'Location: ../index.php' );
        }
    }

    /**
     * Check les paramètres lors de la suppression d'une tâche
     * @param int $idtask
     * @param int $idlist

     * @return void
     */
    public function checkDeleteTask( int $idtask, int $idlist ) :void
    {
        $cls_list = new cls_list();
        $cls_user = new cls_user();

        if( $cls_user->isConnected() === false ){
            throw new Exception( 'Non-connecté' );
        }

        $task = $cls_list->getTaskById( $idtask );

        if( !isset( $idtask ) || !isset( $idlist ) ){
            throw new Exception( 'Données manquantes.' );
            header( 'Location: ../index.php' );
        }

        if( $task === null || $task->login != $_SESSION[ 'profil' ][ 'login' ] ){
            throw new Exception( 'Utilisateur non-valide.' );
            header( 'Location: ../index.php' );
        }

        if( $task->idlist != $idlist ){
            throw new Exception( 'Liste inconnue.' );
            header( 'Location: ../index.php' );
        }
    }

    /**
     * Check les paramètres lors de la modification d'état (complété ou en cours)
     * @param int $idtask

     * @return void
     */
    public function checkUpdateStatus( int $idtask ) :void
    {
        $cls_list = new cls_list();
        $cls_user = new cls_user();

        if( $cls_user->isConnected() === false ){
            throw new Exception( 'Non-connecté' );
        }

        $task = $cls_list->getTaskById( $idtask );

        if( !isset( $idtask ) ){
            throw new Exception( 'Tâche invalide' );
        }

        if( $task === null || $task->login != $_SESSION[ 'profil' ][ 'login' ] ){
            throw new Exception( 'Utilisateur non-valide.' );
            header( 'Location: ../index.php' );
        }
    }
}