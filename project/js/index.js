const axios2 = window.axios
/**
 * handle submission
 */
function submitit () {
    let choices = this.setChoicesArray();
    if (!this.checkForCalculus(choices)) {
        alert('calculus must be one of the choices');
        return;
    }
    axios2.post('/', {
            choices: choices
        })
        .then(response => {
            let data = response;
            alert(data.data);
            console.log(data);
            this.clearChoices();
        })
        .catch(error => {
            let data = error.response;
            alert(data.data);
            console.log(data);
            console.log('fetching data error')
        });
}
/**
 * handle checking choices
 * @param {array} choices 
 */
function checkForCalculus (choices) {
    let response = false;
    choices.forEach(element => {
        field = element.toLowerCase();
        if (field.includes('calculus')) {
            response = true;
        }
    });

    return response;
}

/**
 * clear the vals on success
 */
function clearChoices () {
    document.getElementById('choice1').value = '';
    document.getElementById('choice2').value = '';
    document.getElementById('choice3').value = '';
}

/**
 * set choices from dom
 */
function setChoicesArray () {
    let choicesArray = [];
    choicesArray.push(document.getElementById('choice1').value);
    choicesArray.push(document.getElementById('choice2').value);
    choicesArray.push(document.getElementById('choice3').value);
    return choicesArray;
}