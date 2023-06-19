<?php
include '../assets/include/inc.php';

try
{
    $cls_list = new cls_list();
    $data = $cls_list->addTask( $_POST[ 'libelle' ], $_POST[ 'description' ], $_POST[ 'user' ], $_POST[ 'list' ] );

    $_SESSION[ 'alert' ][ 'success' ] = "Nouvelle tâche ajoutée.";
}
catch( Exception $e )
{
    $_SESSION[ 'alert' ][ 'danger' ] = $e->getMessage();
}

header('Location: ../list.php?idlist=' . $_POST[ 'list' ]);

exit;