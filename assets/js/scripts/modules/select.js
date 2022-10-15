/*
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


*/
// define(['assets/js/scripts/lib/knockout'], function (ko) {
//     return function (items) {
//         let viewModel = {
//             allItems: ko.observableArray(items),
//             pagesCountArray: ko.observableArray([]),
//             currentPage: ko.observable(0),
//             itemsPerPage: ko.observable(4),
//             startIndex: ko.observable(0),
//             currentItems: ko.observableArray([]),
//             nextPage: function () {
//                 if (this.currentPage() >= this.pagesCountArray().length) {
//                     this.currentPage(this.pagesCountArray().length);
//                     return;
//                 }
//                 this.currentPage(this.currentPage() + 1);
//             },
//             prevPage: function () {
//                 if (this.currentPage() <= 1) {
//                     this.currentPage(1);
//                     return;
//                 }
//                 this.currentPage(this.currentPage() - 1);
//             },
//             switchPage: function (event) {
//                 this.currentPage(event);
//             },
//             showPrevLink: ko.observable(true),
//             showNextLink:  ko.observable(true)
//         }
//
//         ko.applyBindings(viewModel);
//     }
// });