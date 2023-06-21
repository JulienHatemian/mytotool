document.addEventListener( "DOMContentLoaded", function() {
    textLength( 'input-add-libelle-list', 'container-add-libelle', 30 );
    textLength( 'input-add-description-list', 'container-add-description', 255 );
    textLength( 'new-task-input', 'new-task-input', 70 );
    textLength( 'task-description', 'task-description', 255 );
    textLength( 'edit-list-input', 'edit-list-input', 30 );
    textLength( 'edit-list-description', 'edit-list-description', 255 );
} )

/**
 * 
 * @param {*} id //Id Task actuel
 * @param {*} modalName //Id du modal
 */
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

            spanSuppression.innerHTML = json.success.libelle_task;
            editLibelle.value = json.success.libelle_task;
            editDescription.value = json.success.description_task;
            deleteTask.value = json.success.idtask;
            editTask.value = json.success.idtask;
            
            textLength( 'edit-task-input', 'edit-task-input', 70 );
            textLength( 'edit-task-description', 'edit-task-description', 255 );
        
            modal.show();

            //Remove la balise small quand celle-ci se trouve dans un modal (À utiliser pour les éditions)
            modal._element.addEventListener( 'hidden.bs.modal', function( event ) {
                if( editLibelle.nextElementSibling.classList.contains( 'info-length' ) && editDescription.nextElementSibling.classList.contains( 'info-length' ) ){
                    editLibelle.nextSibling.remove();
                    editDescription.nextSibling.remove();   
                }
            } )
        }else{
            console.log(ajax.responseText);
            console.log('Erreur AJAX : ' + ajax.status);
        }
    }
    };

    ajax.open('GET', url, true);
    ajax.send();
}

/**
 * 
 * @param {*} inputId //Id de l'input où seront comptés les caractères
 * @param {*} parentId //Parent auquel sera rattaché le compteur (small)
 * @param {*} max //Nombre maximum de caractères
 */
function textLength( inputId, parentId, max ){
    let maxLength = max;
    let input = document.getElementById( inputId );
    let parentContainer = document.getElementById( parentId );
    let spanNumberCharacters = document.createElement( 'span' );
    spanNumberCharacters.classList.add( 'txt-length' );
    let spanNumberAllowCharacters = document.createElement( 'span' );
    spanNumberAllowCharacters.classList.add( 'txt-length-max' );
    spanNumberAllowCharacters.textContent = maxLength;

    //Détermine si du contenu est déjà présent dans l'input
    if( input != null && input.value.length > 0 ){
        spanNumberCharacters.textContent = input.value.length;
    }else{
        spanNumberCharacters.textContent = 0;
    }

    //Met à jour le nombre de caractère tapés
    let updateLength = function(){
        let numberCharacters = input.value.length;
        spanNumberCharacters.textContent = numberCharacters;

        if( maxLength ){
            spanNumberAllowCharacters.textContent = maxLength;
            input.setAttribute( "maxlength", maxLength );

            if( numberCharacters > maxLength ){
                input.value = input.value.slice( 0, maxLength );
                spanNumberCharacters.textContent = maxLength;
            }
        }
    }

    //Créer la balise small
    if( input != null ){
        input.addEventListener( 'input', updateLength );

        //Création de l'élément small
        const small = document.createElement( 'small' );
        small.classList.add( 'd-flex', 'info-length' );
        small.appendChild( spanNumberCharacters );
        small.appendChild( document.createTextNode( '/' ) );
        small.appendChild( spanNumberAllowCharacters );

        //Permet d'éviter de dédoubler l'affichage des balises small quand on ouvre le modal
        if( parentContainer.nextElementSibling != null && !parentContainer.nextElementSibling.classList.contains( 'info-length' ) ){
            parentContainer.parentNode.insertBefore( small, parentContainer.nextSibling );
        }        
    }
}