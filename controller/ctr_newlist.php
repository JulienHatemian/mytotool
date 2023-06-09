<?php
include '../assets/include/inc.php';

try
{
    $cls_list = new cls_list();
    $data = $cls_list->addList( $_POST );

    $_SESSION[ 'alert' ][ 'success' ] = "Votre liste a bien été créé.";
}
catch( Exception $e )
{
    $_SESSION[ 'alert' ][ 'danger' ] = $e->getMessage();
}

header('Location: ../index.php');

exit;