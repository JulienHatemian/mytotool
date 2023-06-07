<nav class="navbar bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">
      MYTOTOOL
    </a>
    <?php
    if( isset( $_SESSION[ 'profil' ] ) ) { ?>
    <a href="logout.php">Déconnexion</a>
    <?php } ?>
  </div>
</nav>