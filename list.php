<?php
    include './assets/partials/header.php';
    include './assets/include/inc.php';
    include './assets/partials/nav.php';

    $cls_list = new cls_list();
    $cls_user = new cls_user();

    if( $cls_user->isConnected() === false ){
        header('Location: connexion.php');
    }elseif( $cls_list->getListById( $_GET[ 'idlist' ] ) === false ){
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
            <input type="text" class="form-control" id="new-task-input" placeholder="Nouvelle tâche" name="libelle">

            <label for="task-description">Description</label>
            <textarea class="form-control description-textarea" name="description" id="task-description" cols="30" rows="10" placeholder="(Optionnel)"></textarea>

            <input type="hidden" value="<?= $_GET[ 'idlist' ] ?>" name="list">
            <input type="hidden" value="<?= $login[ 0 ]->iduser ?>" name="user">

            <button type="submit" class="btn btn-success float-end mt-2">Valider</button>
        </form>
    </div>

    <div class="list-overall col-md-8 d-flex flex-column mx-3">
        <?php  if( count( $ongoing ) > 0 ){ ?>
        <div class="list-ongoing mb-5 rounded border-3 border border-secondary">
            <div class="header-list text-center bg-danger fw-bold text-white py-2">Tâches en cours</div>
            <div class="list-body">
                <div class="accordion accordion-flush" id="accordionFlushOngoing">
                    <?php foreach( $ongoing as $key => $item ){ ?>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="flush-heading<?= $key ?>">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse<?= $key ?>-ongoing" aria-expanded="false" aria-controls="flush-collapse<?= $key ?>">
                            <?= $item->libelle ?>
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
                            <?= $item->libelle ?>
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
</div>



<?php
    include './assets/partials/footer.php';
?>