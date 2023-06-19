<?php
include '../assets/include/inc.php';

try
{
    $cls_list = new cls_list();
    $data = $cls_list->deleteTask( $_POST[ 'task' ], $_POST[ 'list' ] );

    $_SESSION[ 'alert' ][ 'success' ] = "Tâche supprimée.";
}
catch( Exception $e )
{
    $_SESSION[ 'alert' ][ 'danger' ] = $e->getMessage();
}

header('Location: ../list.php?idlist=' . $_POST[ 'list' ]);

exit;