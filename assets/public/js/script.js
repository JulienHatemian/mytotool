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

    spanSuppression.innerHTML = '';

    ajax.onreadystatechange = function() {
    if( ajax.readyState === 4 ){
        if( ajax.status === 200 ){
            let modal = new bootstrap.Modal( document.getElementById( modalName ) );
            let json = JSON.parse( this.response );
            spanSuppression.innerHTML = json.success;
            
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
