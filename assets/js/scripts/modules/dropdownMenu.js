// Base content dropdown menu about pages

// const dropdownLinks = document.querySelectorAll('.dropdown-menu') ?? [];
// const dropdownItems = document.querySelectorAll('.dropdown-item') ?? [];

// document.addEventListener('click', ev => {
//     let currentDropdown = ev.target;
//     if (!ev.target.classList.contains('dropdown-toggle')) {
//         dropdownLinks.forEach(btn => btn.classList.remove('active'));
//     } else {
//         let list = ev.target.nextElementSibling;
//         list.classList.add('active');
//
//         dropdownItems.forEach(item => {
//             item.addEventListener('click', event => {
//                 currentDropdown.textContent = event.target.textContent
//             })
//
//             let currentLinkText = item.target.textContent;
//
//             switch (currentLinkText) {
//                 case 'Select All' :
//                     break;
//                 case 'Select All' :
//                     break;
//                 case 'Unselect This Page' :
//                     break;
//                 case 'Unselect This Page' :
//                     break;
//             }
//         })
//     }
// });


define(['assets/js/scripts/lib/knockout'], function (ko) {
    return function () {
        let viewModel = {
            isActiveMenu: ko.observable(false),
            switchMenu: function () {
                this.isActiveMenu(!this.isActiveMenu());
            },
        }

        ko.applyBindings(viewModel);
    }
});