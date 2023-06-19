<?php
    include './assets/partials/header.php';
    include './assets/include/inc.php';
    include './assets/partials/nav.php';

    $cls_user = new cls_user();
    if( $cls_user->isConnected() === true ){
        header('Location: index.php');
    }
?>
<div class="alert-error container my-2">
    <?= alert(); ?>
</div>
<form class="container d-flex flex-column mt-5" action="./controller/ctr_connexion.php" method="post" id="connexion">
    <div class="mb-3">
        <label for="login" class="form-label text-secondary">Adresse mail</label>
        <input type="text" class="form-control" id="login" name="login">
    </div>
    <div class="mb-3">
        <label for="password" class="form-label text-secondary">Mot de passe</label>
        <input type="password" class="form-control" id="password" name="password">
    </div>

    <button type="submit" class="btn btn-success mb-2">Se connecter</button>
    <p class="text-center text-secondary">Vous n'avez pas encore de compte ? <a href="join.php" class="text-info">Inscrivez-vous</a></p>
</form>

<?php
    include './assets/partials/footer.php';
?>