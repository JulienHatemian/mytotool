<?php
include '../assets/include/inc.php';

$out = array();
try
{
    $cls_list = new cls_liste();
    $data = $cls_annonceur->getListe( $_POST );

    $out = ( array ) $data;
    $out[ 'success' ] = "Annonceur ajouté.";
}
catch( Exception $e )
{
    $out[ 'error' ] = $e->getMessage();
}

echo json_encode( $out );
exit;