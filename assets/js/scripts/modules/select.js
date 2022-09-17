// Select controller

const selectAllBtn = document.querySelectorAll('.select-action');
const selectedFields = document.querySelectorAll('.controller-select-field');

selectAllBtn.forEach(selectAllBtn => {
    selectAllBtn.addEventListener('click', function() {
        let selectAction = this.textContent;
        switch (selectAction) {
            case 'Select All' :
                selectUsersAction(true);
                break;
            case 'Unselect All' :
                selectUsersAction(false);
                break;
        }
    });
})

function selectUsersAction(action) {
    selectedFields.forEach(selectedField => {
        selectedField.checked = action;
    })
}
