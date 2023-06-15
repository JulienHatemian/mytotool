//CREER UN CONTROLLER ET UNE FONCTION POUR RECUPERER LES INFO 
// public function showModal( $params )
// {
//     $this->checkModal( $params );

//     $result = $this->get( $params );

//     return $result;
// }

function modal( id, modalName) {
    let ajax = new XMLHttpRequest();
    let url = './controller/ctr_modal.php?id=' + id;
    let spanSuppression = document.getElementById( 'libelle-suppression' );
    let editLibelle = document.getElementById( 'edit-task-input' );
    let editDescription = document.getElementById( 'edit-task-description' );
    let deleteTask = document.getElementById( 'delete-task' );
    let editTask = document.getElementById( 'edit-task' );

    spanSuppression.innerHTML = '';

    ajax.onreadystatechange = function() {
    if( ajax.readyState === 4 ){
        if( ajax.status === 200 ){
            let modal = new bootstrap.Modal( document.getElementById( modalName ) );
            let json = JSON.parse( this.response );
            // console.log( json );
            spanSuppression.innerHTML = json.success.libelle_task;
            editLibelle.value = json.success.libelle_task;
            editDescription.value = json.success.description_task;
            deleteTask.value = json.success.idtask;
            editTask.value = json.success.idtask;
            
            modal.show();
        }else{
            console.log(ajax.responseText);
            console.log('Erreur AJAX : ' + ajax.status);
        }
    }
    };

    ajax.open('GET', url, true);
    ajax.send();
}
