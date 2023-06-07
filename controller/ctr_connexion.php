<?php
include '../assets/include/inc.php';

// $out = array();
try
{
    $cls_user = new cls_user();
    $data = $cls_user->getConnected( $_POST );

    $_SESSION[ 'alert' ][ 'success' ] = "Bienvenue";
}
catch( Exception $e )
{
    $_SESSION[ 'alert' ][ 'danger' ] = $e->getMessage();
}

header('Location: ../index.php');
exit;