<?php
    include './assets/partials/header.php';
    include './assets/include/inc.php';
    include './assets/partials/nav.php';

    $cls_user = new cls_user();
    if( $cls_user->isConnected() === true ){
        header('Location: index.php');
    }
?>
<div class="alert-error container">
    <?= alert(); ?>
</div>	
<h1 class="ms-2">Création de compte</h1>
<form class="container d-flex flex-column" action="./controller/ctr_join.php" method="post" id="connexion">
    <div class="mb-3">
        <label for="login" class="form-label text-secondary">Adresse mail</label>
        <input type="text" class="form-control" id="login" name="login" required>
    </div>
    <div class="mb-3">
        <label for="password" class="form-label text-secondary">Mot de passe</label>
        <input type="password" class="form-control" id="password" name="password" required>
    </div>
    <div class="mb-3">
        <label for="password" class="form-label text-secondary">Confirmer mot de passe</label>
        <input type="password" class="form-control" id="password-confirmation" name="password_confirmation" required>
    </div>
    <div id="passwordHelp" class="form-text text-center text-warning mb-3">Votre mot de passe doit contenir au moins 8 caractères, une majuscule et un chiffre</div>

    <button type="submit" class="btn btn-success">Rejoindre</button>
    <p class="text-center text-secondary">Vous possédez déjà un compte ? <a href="connexion.php" class="text-info">Connectez-vous</a></p>
</form>

<?php
    include './assets/partials/footer.php';
?>