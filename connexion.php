<?php
    include './assets/partials/header.php';
    include './assets/include/inc.php';
    include './assets/partials/nav.php';

    // $user = array();
    // $user['login'] = 'test';
    // $user['password'] = password_hash( 'test', PASSWORD_BCRYPT );
    // $cls_user = new cls_user();
    // $cls_user->addUser( $user );

    // $cls_user->getConnected( ['login' => 'test' ] );
    var_dump( $_SESSION );
?>
<div class="alertConnexion">
    <?= alert(); ?>
</div>	
<h1>Page de connexion</h1>
<form class="container d-flex flex-column" action="./controller/ctr_connexion.php" method="post" id="connexion">
    <div class="mb-3">
        <label for="login" class="form-label">Login</label>
        <input type="text" class="form-control" id="login" name="login">
    </div>
    <div class="mb-3">
    <label for="password" class="form-label">Mot de passe</label>
    <input type="password" class="form-control" id="password" name="password">
    </div>

    <button type="submit" class="btn btn-success">Se connecter</button>
</form>
<p class="text-center">Vous n'avez pas encore de compte ? <a href="#">Inscrivez-vous</a></p>

<?php
    include './assets/partials/footer.php';
?>