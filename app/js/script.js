async function callAPIDelete(params) {
    try {
        const response = await fetch("api.php?" + params);
        const json = await response.json();

    } catch (error) {
        
    }
}
let tetsId = document.querySelector('[data-task-id]');
console.log(tetsId);