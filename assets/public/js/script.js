document.addEventListener( "DOMContentLoaded", function() {
    textLength( 'input-add-libelle-list', 'container-add-libelle', 30 );
    textLength( 'input-add-description-list', 'container-add-description', 255 );
} )

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

function textLength( inputId, parent, max ){
    let maxLength = max;
    let input = document.getElementById( inputId );
    let parentContainer = document.getElementById( parent );
    let spanNumberCharacters = document.createElement( 'span' );
    spanNumberCharacters.classList.add( 'txt-length' );
    spanNumberCharacters.textContent = 0;
    let spanNumberAllowCharacters = document.createElement( 'span' );
    spanNumberAllowCharacters.classList.add( 'txt-length-max' );
    spanNumberAllowCharacters.textContent = maxLength;

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

    input.addEventListener( 'input', updateLength );

    const small = document.createElement( 'small' );
    small.classList.add( 'd-flex' );

    small.appendChild( spanNumberCharacters );
    small.appendChild( document.createTextNode( '/' ) );
    small.appendChild( spanNumberAllowCharacters );

    parentContainer.parentNode.insertBefore( small, parentContainer.nextSibling );
}