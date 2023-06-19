<nav class="navbar navbar-dark bg-dark">
  <div class="container-fluid py-3">
    <a class="navbar-brand" href="index.php">
      MYTOTOOL
    </a>
    <?php
    if( isset( $_SESSION[ 'profil' ] ) ) { ?>
    <a href="logout.php" class="text-white">Déconnexion</a>
    <?php } ?>
  </div>
</nav>