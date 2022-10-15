let terminalModal = document.querySelector('.overlay');
let terminalArea = document.querySelector('.terminal-area');

let lastSearchCommand = '';

document.addEventListener('keydown', ev => {
    if (ev.key === "F12" && ev.ctrlKey) {
        setModalActive();
    }
    if (ev.key === "Enter" && isActiveModal()) {
        sendTerminalRequest().then(resp => {
            if (resp !== '') {
                terminalArea.value = terminalArea.value + resp + '\n';
                return;
            }
        });
    }
    if (
        (ev.key === "Backspace" || ev.key === "Delete") &&
        isActiveModal()
    ) {
        ev.preventDefault();
    }
});

function setModalActive() {
    if (isActiveModal()) {
        terminalModal.classList.remove('active');
    } else {
        terminalModal.classList.add('active');
    }
}

function isActiveModal() {
    return terminalModal.classList.contains('active');
}

// function setActiveModal() {
//     terminalModal.classList.add('active');
// }
//
// function setDisableModal() {
//     terminalModal.classList.remove('active');
// }

async function sendTerminalRequest() {
    let searchValue = terminalArea.value;
    let arrayOfSearches = searchValue.match(/(.*\b)/gm);
    let command = arrayOfSearches[arrayOfSearches.length - 2];
    let body = {
        command
    };
    lastSearchCommand = command;
    let request = await fetch('/CLI', {
        method: "post",
        body: JSON.stringify(body)
    });
    return await request.json();
}