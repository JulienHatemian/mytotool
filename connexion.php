<?php
    include './assets/partials/header.php';
    include './assets/include/inc.php';
    include './assets/partials/nav.php';

    $cls_user = new cls_user();
    if( $cls_user->isConnected() === true ){
        header('Location: index.php');
    }
?>
<h1>Page de connexion</h1>
<div class="alert-error container">
    <?= alert(); ?>
</div>
<form class="container d-flex flex-column" action="./controller/ctr_connexion.php" method="post" id="connexion">
    <div class="mb-3">
        <label for="login" class="form-label">Adresse mail</label>
        <input type="text" class="form-control" id="login" name="login">
    </div>
    <div class="mb-3">
    <label for="password" class="form-label">Mot de passe</label>
    <input type="password" class="form-control" id="password" name="password">
    </div>

    <button type="submit" class="btn btn-success">Se connecter</button>
</form>
<p class="text-center">Vous n'avez pas encore de compte ? <a href="join.php">Inscrivez-vous</a></p>

<?php
    include './assets/partials/footer.php';
?>