<?php
include '../assets/include/inc.php';

$out = array();
try
{
    $cls_user = new cls_user();
    $data = $cls_user->isConnected();

    // $out = ( array ) $data;
    // $out[ 'success' ] = "Bienvenue" . $data['login'];
    // $_SESSION[ 'alert' ] = ["success" => "Bienvenue" . $data['login'] ];
}
catch( Exception $e )
{
    $out[ 'error' ] = $e->getMessage();
    // $_SESSION[ 'alert' ] = ["danger" => "Identifiant(s) incorrects" ];
}

// echo json_encode( $out );
exit;