<?php

class cls_check
    extends cls_core
{
    public function checkLogin( $params ){
        $cls_user = new cls_user();
        if( count( $cls_user->loginExist( $params['login'] ) ) == 0 ){
            throw new Exception( 'Identifiants non-valides !' );
        }
    }
}