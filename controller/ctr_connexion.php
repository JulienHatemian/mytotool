<?php
include '../assets/include/inc.php';

try
{
    $cls_user = new cls_user();
    $data = $cls_user->getConnected( $_POST[ 'login' ], $_POST[ 'password' ] );

    $_SESSION[ 'alert' ][ 'success' ] = "Bienvenue sur votre totool personnelle !";
}
catch( Exception $e )
{
    $_SESSION[ 'alert' ][ 'danger' ] = $e->getMessage();
}

header('Location: ../index.php');
exit;