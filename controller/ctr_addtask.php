<?php
include '../assets/include/inc.php';

try
{
    $cls_list = new cls_list();
    $data = $cls_list->addTask( $_POST );

    $_SESSION[ 'alert' ][ 'success' ] = "Nouvelle tâche ajoutée.";
}
catch( Exception $e )
{
    $_SESSION[ 'alert' ][ 'danger' ] = $e->getMessage();
}

header('Location: ../list.php?idlist=' . $_POST[ 'list' ]);

exit;