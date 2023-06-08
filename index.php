<?php
    include './assets/partials/header.php';
    include './assets/include/inc.php';
    include './assets/partials/nav.php';

    $cls_liste = new cls_liste();
    $cls_user = new cls_user();

    if( $cls_user->isConnected() === false ){
        header('Location: connexion.php');
    }else{
        $login = $cls_user->getLogin( $_SESSION[ 'profil' ][ 'login' ] );
        var_dump( $cls_liste->getListByUser( $login[ 0 ]->iduser ) );
    }
?>
    <h1>Vos listes</h1>
    
<?php
    include './assets/partials/footer.php';
?>