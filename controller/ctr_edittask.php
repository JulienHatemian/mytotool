<?php
include '../assets/include/inc.php';

try
{
    $cls_list = new cls_list();
    $data = $cls_list->editTask( $_POST[ 'task' ], $_POST[ 'list' ], $_POST[ 'libelle' ], $_POST[ 'description' ] );

    $_SESSION[ 'alert' ][ 'success' ] = "Tâche modifée";
}
catch( Exception $e )
{
    $_SESSION[ 'alert' ][ 'danger' ] = $e->getMessage();
}

header('Location: ../list.php?idlist=' . $_POST[ 'list' ]);

exit;