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
<h1>Création de compte</h1>
<form class="container d-flex flex-column" action="./controller/ctr_join.php" method="post" id="connexion">
    <div class="mb-3">
        <label for="login" class="form-label">Adresse mail</label>
        <input type="text" class="form-control" id="login" name="login">
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Mot de passe</label>
        <input type="password" class="form-control" id="password" name="password">
        <label for="password" class="form-label">Confirmer mot de passe</label>
        <input type="password" class="form-control" id="password-confirmation" name="password_confirmation">
        <div id="passwordHelp" class="form-text text-center">Votre mot de passe doit contenir au moins 8 caractères, une majuscule, un chiffre et un caractère spécial</div>
    </div>

    <button type="submit" class="btn btn-success">Rejoindre</button>
</form>

<?php
    include './assets/partials/footer.php';
?>