<?php

class cls_check
    extends cls_core
{
    public function checkLogin( $params ){
        $cls_user = new cls_user();
        $user = $cls_user->getLogin( $params[ 'login' ] );
        if( count( $cls_user->getLogin( $params['login'] ) ) == 0 || !password_verify( $params[ 'password' ], $user[ 0 ]->password ) || !$params[ 'login' ] || !$params[ 'password' ] ){
            throw new Exception( 'Identifiant ou mot de passe invalides !' );
        }
    }

    public function checkJoin( $params ){
        $cls_user = new cls_user();

        if( count( $cls_user->getLogin( $params['login'] ) ) > 0 ){
            throw new Exception( 'Login déjà existant' );
        }

        if( !$params[ 'login' ] || !$params[ 'password' ] || !$params[ 'password_confirmation' ] ){
            throw new Exception( 'Veuillez compléter les champs requis' );
        }

        if ( !filter_var( $params[ 'login' ], FILTER_VALIDATE_EMAIL ) && strlen( $params[ 'login' ] ) > 255 ) {
            throw new Exception( 'Veuillez rentrer un format de mail valide et avec 255 caractères maximum.' );
          }

        if ( ( strlen( $params[ 'password' ] ) < 8 || strlen( $params[ 'password' ] ) > 255 ) || !preg_match("/\d/", $params[ 'password' ] ) || !preg_match("/[A-Z]/", $params[ 'password' ] ) || !preg_match("/[a-z]/", $params[ 'password' ] ) || !preg_match( "/\W/", $params[ 'password' ] ) ) {
            throw new Exception( 'Votre mot de passe doit contenir au moins 8 caractères, une minuscule, une majuscule, un chiffre et un caractère spécial' );
        }

        if( $params[ 'password' ] != $params[ 'password_confirmation' ] ){
            throw new Exception( 'Les mots de passes de confirmation ne sont pas identiques.' );
        }
    }

    public function checkAddList( $params ){
        $cls_user = new cls_user();
        $user = $cls_user->getLogin( $_SESSION[ 'profil' ][ 'login' ] );
        if( $params[ 'user' ] != $user[ 0 ]->iduser ){
            throw new Exception( 'Utilisateur non-valide.' );
        }
    }

    public function checkAddTask( $params ){
        $cls_user = new cls_user();
        $cls_list = new cls_list();
        $user = $cls_user->getLogin( $_SESSION[ 'profil' ][ 'login' ] );
        if( $params[ 'user' ] != $user[ 0 ]->iduser ){
            throw new Exception( 'Utilisateur non-valide.' );
        }

        if( $cls_list->getListById( $params[ 'list' ] ) === false ){
            throw new Exception( 'Liste non-valides' );
            header( 'Location: ../index.php' );
        }

        if( empty( $params[ 'libelle' ] ) ){
            throw new Exception( 'Nom de tâche non-valide' );
        }
        
        if( strlen( $params[ 'libelle' ] ) > 255 || strlen( $params[ 'description' ] ) > 255 ){
            throw new Exception( 'Le nom de la tâche et de la description ne doivent pas exéder les 255 caractères.' );
        }
    }

    public function checkModal( $params ){
        $cls_list = new cls_list();
        $task = $cls_list->getTaskById( $params );

        if( $task->login != $_SESSION[ 'profil' ][ 'login' ] ){
            throw new Exception( 'Tâche non-valides' );
            header( 'Location: ../index.php' );
        }
    }
}