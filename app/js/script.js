import * as Task from './_functions.js';


let taskId = document.querySelectorAll('[data-task-id]');
let btnSup = document.querySelector('[data-delete]');
let btnFinish = document.querySelector('[data-finish]');

taskId.forEach(function(taskItm) {
    taskItm.addEventListener('click', function (e) {

        let valueId = taskItm.dataset.taskId;

        btnSup.addEventListener('click', function (e) {
            Task.deleteTask(parseInt(valueId));
        })

        // btnFinish.addEventListener('click', function (e) {
        //     console.log("click");
        //     callAPIFinish('action=Terminer&id=' + valueId + '&token=' + document.getElementById('token').value)
        // })
    })
})

