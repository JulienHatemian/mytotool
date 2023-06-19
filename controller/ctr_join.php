<?php
include '../assets/include/inc.php';

try
{
    $cls_user = new cls_user();
    $data = $cls_user->join( $_POST[ 'login' ], $_POST[ 'password' ], $_POST[ 'password_confirmation' ] );

    $_SESSION[ 'alert' ][ 'success' ] = "Votre compte a bien été créé.";
}
catch( Exception $e )
{
    $_SESSION[ 'alert' ][ 'danger' ] = $e->getMessage();
}

if( isset( $_SESSION[ 'alert' ][ 'success' ] ) ){
    header('Location: ../connexion.php');
}else{
    header('Location: ../join.php');
}
exit;