<?php
    include './assets/partials/header.php';
    include './assets/include/inc.php';
    include './assets/partials/nav.php';

    $cls_list = new cls_list();
    $cls_user = new cls_user();

    if( $cls_user->isConnected() === false ){
        header('Location: connexion.php');
    }else{
        $login = $cls_user->getLogin( $_SESSION[ 'profil' ][ 'login' ] );
        $listes = $cls_list->getListByUser( $login[ 0 ]->iduser );
        $types = $cls_list->getTypeList();
    }
?>
    <h1 class="ms-2">Vos listes:</h1>
    <div class="alert-error container">
        <?= alert(); ?>
    </div>
    <div class="listes container d-flex flex-wrap col-12">
        <a class="liste add-list d-flex justify-content-center align-items-center" href="#" data-bs-toggle="modal" data-bs-target="#add-list">
            <p id="add-sign">+</p>
        </a>

        <?php foreach( $listes as $liste ){ ?>
            <a class="liste d-flex justify-content-center align-items-center" href="list.php?idlist=<?= $liste->idlist ?>">
                <p class="fw-bold text-break text-center m-1"><?= $liste->libelle ?></p>
            </a>
        <?php } ?>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="add-list" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h1 class="modal-title fs-5 fw-bold text-white" id="staticBackdropLabel">Ajouter une nouvelle liste</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="./controller/ctr_newlist.php" method="post">
                    <div class="modal-body">
                        <label for="select-type" class="fw-bold">Type de liste:</label>
                        <select class="form-select mb-3" aria-label=".form-select-lg" id="select-type" name="type">
                            <?php foreach( $types as $type ){ ?>
                                <option value="<?= $type->idtypelist ?>"><?= $type->libelle ?></option>
                            <?php } ?>
                        </select>

                        <div class="input-group" id="container-add-libelle">
                            <label class="input-group-text fw-bold" for="input-add-libelle-list">Libelle</label>
                            <input type="text" aria-label="libelle list" class="form-control" name="libelle" id="input-add-libelle-list" maxlength="30">
                        </div>

                        <div class="mt-3" id="container-add-description">
                            <label class="form-label fw-bold" for="input-add-description-list">Description</label>
                            <textarea class="form-control description-textarea" placeholder="De quoi parle votre liste ?" id="input-add-description-list" name="description" maxlength="255"></textarea>
                        </div>
                        <input type="hidden" value="<?= $login[ 0 ]->iduser ?>" name="user">
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-success">Valider</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php
    include './assets/partials/footer.php';
?>