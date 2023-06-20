<?php
include '../assets/include/inc.php';

try
{
    $cls_list = new cls_list();
    $data = $cls_list->deleteList( $_POST[ 'list' ] );

    $_SESSION[ 'alert' ][ 'success' ] = "Liste supprimée.";
}
catch( Exception $e )
{
    $_SESSION[ 'alert' ][ 'danger' ] = $e->getMessage();
}

header( 'Location: ../index.php' );

exit;