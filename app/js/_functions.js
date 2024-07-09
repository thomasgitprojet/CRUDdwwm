/**
 * Generate asynchronous call to api.php with parameters
 * @param {*} method GET, POST, PUT or DELETE
 * @param {*} params An object with data to send.
 * @returns 
 */
async function callAPI(method, params) {
    try {
        const response = await fetch("api.php", {
            method: method,
            body: JSON.stringify(params),
            headers: {
                'Content-type': 'application/json'
            }
        });
        const dataResponse = await response.json();
        return dataResponse;
    }
    catch (error) {
        console.error("Unable to load datas from server : " + error);
    }
}

/**
 * Get current global token value.
 * @returns 
 */
function getToken() {
    return document.getElementById('token').value;
}

export function deleteTask (id) {

    if (!Number.isInteger(id)) {
        displayError("Impossible de déterminer l'identifiant du produit.");
        return;
    }

    const token = getToken();

    if (!token.length) {
        displayError("Jeton invalide.");
        return;
    }

    callAPI('DELETE', {
        action: 'Supprimer',
        id: id,
        token: token
    })
        .then(data => {
            if (!data.isOk) {
                displayError(data.errorMessage);
                return;
            }

            data.id = parseInt(data.id);

            if (!Number.isInteger(data.id)) {
                displayError("Données reçues incohérentes");
                return;
            }

            let element = document.querySelector(`[data-task-id="${data.id}"]`); 

            element.remove();

            displayMessage('Tâche supprimée avec succès'); 

        })
}

/**
 * Display error message with template
 * @param {string} errorMessage 
 */
function displayError(errorMessage) {
    const li = document.importNode(document.getElementById('templateError').content, true);
    console.log(li.querySelector('[data-error-message]'));
    const m = li.querySelector('[data-error-message]');
    m.innerText = errorMessage;
    document.getElementById('errorsList').appendChild(li);
    setTimeout(() => m.remove(), 2000);
    // console.error(errorMessage);
}

/**
 * Display message with template
 * @param {string} message 
 */
function displayMessage(message) {
    const li = document.importNode(document.getElementById('templateMessage').content, true);
    const m = li.querySelector('[data-message]')
    m.innerText = message;
    document.getElementById('messagesList').append(li);
    setTimeout(() => m.remove(), 2000);
    // console.log(message);
}