<?php
    include './assets/include/inc.php';
    include './assets/partials/nav.php';

    session_start();
    session_destroy();
    header( 'Location: connexion.php' );
?>