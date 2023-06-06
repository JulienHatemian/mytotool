<?php
    include './assets/partials/header.php';
    include './assets/include/inc.php';
    include './assets/partials/nav.php';

    $cls_liste = new cls_liste();
    $cls_user = new cls_user();
    // var_dump( $cls_user->isConnected() );
    // var_dump( $cls_liste->getListe( 1 ) );
    if( $cls_user->isConnected() === false ){
        header('Location: connexion.php');
    }
?>
    <h1>Page accueil</h1>
<?php
    include './assets/partials/footer.php';
?>