<?php
include '../assets/include/inc.php';

try
{
    // var_dump( $_POST );
    // exit;
    $cls_list = new cls_list();
    $data = $cls_list->editTask( $_POST );

    $_SESSION[ 'alert' ][ 'success' ] = "Tâche modifée";
}
catch( Exception $e )
{
    $_SESSION[ 'alert' ][ 'danger' ] = $e->getMessage();
}

header('Location: ../list.php?idlist=' . $_POST[ 'list' ]);

exit;