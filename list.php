<?php
    include './assets/partials/header.php';
    include './assets/include/inc.php';
    include './assets/partials/nav.php';

    $cls_list = new cls_list();
    $cls_user = new cls_user();

    if( $cls_user->isConnected() === false ){
        header('Location: connexion.php');
    }elseif( $cls_list->getListById( (int) $_GET[ 'idlist' ] ) === false ){
        $_SESSION['alert']['danger'] = "Paramètres non-valides";
        header( 'Location: index.php' );
    }else{
        $login = $cls_user->getLogin( $_SESSION[ 'profil' ][ 'login' ] );
        $liste = $cls_list->getListById( $_GET[ 'idlist' ] );
        $ongoing = $cls_list->getTaskOnGoing( $_GET[ 'idlist' ] );
        $complete = $cls_list->getTaskComplete( $_GET[ 'idlist' ] );
    }
?>

<h2 class="ms-3 mt-3"><?= $liste->libelle ?></h2>
<small class="ms-4"><?= $liste->description ?></small>
<div class="alert-error container">
    <?= alert(); ?>
</div>
<div class="d-flex mt-3">
    <div class="new-task d-flex flex-column p-3 align-items-center col-md-3">
        <form action="./controller/ctr_addtask.php" method="post">
            <label for="new-task-input" class="mb-1 fw-bold">Ajouter une nouvelle tâche:</label>
            <input type="text" class="form-control" id="new-task-input" placeholder="Nouvelle tâche" name="libelle" maxlength="80">

            <label for="task-description">Description</label>
            <textarea class="form-control description-textarea" name="description" id="task-description" cols="30" rows="10" placeholder="(Optionnel)" maxlength="255"></textarea>

            <input type="hidden" value="<?= $_GET[ 'idlist' ] ?>" name="list">
            <input type="hidden" value="<?= $login[ 0 ]->iduser ?>" name="user">

            <button type="submit" class="btn btn-success float-end mt-2">Valider</button>
        </form>
    </div>

    <div class="list-overall col-md-8 d-flex flex-column mx-3">
      <?php if( count( $ongoing ) > 0 || count( $complete ) > 0 ){ ?>
        <?php  if( count( $ongoing ) > 0 ){ ?>
        <div class="list-ongoing mb-5 rounded border-3 border border-secondary">
            <div class="header-list text-center bg-danger fw-bold text-white py-2">Tâches en cours</div>
            <div class="list-body">
                <div class="accordion accordion-flush" id="accordionFlushOngoing">
                    <?php foreach( $ongoing as $key => $item ){ ?>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="flush-heading<?= $key ?>">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse<?= $key ?>-ongoing" aria-expanded="false" aria-controls="flush-collapse<?= $key ?>">
                            <div><?=  mb_strimwidth( $item->libelle, 0, 90 ) ?> ............. </div>
                            <div class="ms-3 btn-action">
                                <a class="btn btn-warning" href="javascript:;" onclick="javascript:modal( <?= $item->idtask ?>, 'modalEdition' )"><img src="./assets/public/img/icons8-edit-text-file-50.png" alt="logo édition" class="logo-list"></a>
                                <a class="btn btn-danger" href="javascript:;" onclick="javascript:modal( <?= $item->idtask ?>, 'modalSuppression' )"><img src="./assets/public/img/icons8-supprimer-50.png" alt="logo suppression" class="logo-list"></a>
                                <a class="btn btn-success" href="./controller/ctr_updatestatus.php?task=<?= $item->idtask ?>&list=<?= $_GET[ 'idlist' ] ?>"><img src="./assets/public/img/icons8-approbation-64.png" alt="logo complété" class="logo-list"></a>
                            </div>
                        </button>
                        </h2>
                        <div id="flush-collapse<?= $key ?>-ongoing" class="accordion-collapse collapse" aria-labelledby="flush-heading<?= $key ?>" data-bs-parent="#accordionFlushOngoing">
                            <div class="accordion-body fst-italic text-secondary"><?php if( strlen( $item->description ) > 0 ) { ?><?= $item->description ?><?php }else{ ?><small class="fst-italic">Pas de description disponible</small><?php } ?></div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <?php } ?>

        <?php  if( count( $complete ) > 0 ){ ?>
        <div class="list-complete rounded border-3 border border-secondary">
            <div class="header-list text-center bg-success fw-bold text-white py-2">Tâches complétées</div>
            <div class="list-body">
                <div class="accordion accordion-flush" id="accordionFlushComplete">
                    <?php foreach( $complete as $key => $item ){ ?>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="flush-headingOne">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse<?= $key ?>-complete" aria-expanded="false" aria-controls="flush-collapse<?= $key ?>">
                            <div><?=  mb_strimwidth( $item->libelle, 0, 90 ) ?> ............. </div>
                            <div class="ms-3 btn-action d-flex justify-content-between">
                                <a class="btn btn-warning me-1" href="javascript:;" onclick="javascript:modal( <?= $item->idtask ?>, 'modalEdition' )"><img src="./assets/public/img/icons8-edit-text-file-50.png" alt="logo édition" class="logo-list"></a>
                                <a class="btn btn-danger me-1" href="javascript:;" onclick="javascript:modal( <?= $item->idtask ?>, 'modalSuppression' )"><img src="./assets/public/img/icons8-supprimer-50.png" alt="logo suppression" class="logo-list"></a>
                                <a class="btn btn-info" href="./controller/ctr_updatestatus.php?task=<?= $item->idtask ?>&list=<?= $_GET[ 'idlist' ] ?>"><img src="./assets/public/img/icons8-minuteur-80.png" alt="logo en cours" class="logo-list"></a>
                            </div>
                        </button>
                        </h2>
                        <div id="flush-collapse<?= $key ?>-complete" class="accordion-collapse collapse" aria-labelledby="flush-heading<?= $key ?>" data-bs-parent="#accordionFlushComplete">
                            <div class="accordion-body fst-italic text-secondary"><?php if( strlen( $item->description ) > 0 ) { ?><?= $item->description ?><?php }else{ ?><small class="fst-italic">Pas de description disponible</small><?php } ?></div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
    <?php }else{ ?>
      <small class="text-center fst-italic text-secondary mt-5">Aucune tâche renseignée pour le moment</small>
    <?php } ?>
</div>

<!-- Modal Suppression -->
<div class="modal fade" id="modalSuppression" tabindex="-1" aria-labelledby="ModalSuppressionLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-danger">
        <h1 class="modal-title fs-5 text-white fw-bold" id="ModalSuppressionLabel">Suppression de tâche</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="./controller/ctr_deletetask.php" method="post">
        <div class="modal-body">
          <p>
            Attention vous allez supprimer la tâche <span class="fw-bold fst-italic text-warning" id="libelle-suppression"></span>, cette opération est <span class="text-danger fw-bold">irréversible</span>.<br><br>Êtes-vous sûr de vouloir continuer ?
          </p>
          <input type="hidden" name="task" id="delete-task" value="">
          <input type="hidden" name="list" value="<?= $_GET[ 'idlist' ] ?>">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
          <button type="submit" class="btn btn-danger">Supprimer</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Edition -->
<div class="modal fade" id="modalEdition" tabindex="-1" aria-labelledby="ModalEditionLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-warning">
        <h1 class="modal-title fs-5 text-white fw-bold" id="ModalEditionLabel">Edition de tâche</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="./controller/ctr_edittask.php" method="post">
        <div class="modal-body">
          <label for="new-task-input" class="mb-1 fw-bold">Libelle tâche:</label>
          <input type="text" class="form-control" id="edit-task-input" name="libelle" maxlength="80">

          <label for="task-description">Description</label>
          <textarea class="form-control description-textarea" name="description" id="edit-task-description" cols="30" rows="10" placeholder="(Optionnel)" maxlength="255"></textarea>

          <input type="hidden" name="task" id="edit-task" value="">
          <input type="hidden" name="list" value="<?= $_GET[ 'idlist' ] ?>">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
          <button type="submit" class="btn btn-warning text-white">Editer</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php
    include './assets/partials/footer.php';
?>