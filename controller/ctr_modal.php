<?php
include '../assets/include/inc.php';

$out = array();

try
{
    $cls_list = new cls_list();

    $data = $cls_list->showModal( $_GET[ 'id' ] );

    $out[ 'success' ] = $data;
}
catch( Exception $e )
{
    $out[ 'error' ] = $e->getMessage();
}

echo json_encode( $out );
exit;