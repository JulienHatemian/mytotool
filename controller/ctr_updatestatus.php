<?php
include '../assets/include/inc.php';

try
{
    $cls_list = new cls_list();
    $data = $cls_list->updateStatus( (int) $_GET[ 'task' ] );

    $_SESSION[ 'alert' ][ 'success' ] = "Status de tâche modifiée";
}
catch( Exception $e )
{
    $_SESSION[ 'alert' ][ 'danger' ] = $e->getMessage();
}

header('Location: ../list.php?idlist=' . $_GET[ 'list' ]);

exit;