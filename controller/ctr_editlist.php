<?php
include '../assets/include/inc.php';

try
{
    $cls_list = new cls_list();
    $data = $cls_list->editList( $_POST[ 'list' ], $_POST[ 'libelle' ], $_POST[ 'description' ] );

    $_SESSION[ 'alert' ][ 'success' ] = "Liste modifée";
}
catch( Exception $e )
{
    $_SESSION[ 'alert' ][ 'danger' ] = $e->getMessage();
}

header('Location: ../list.php?idlist=' . $_POST[ 'list' ]);

exit;