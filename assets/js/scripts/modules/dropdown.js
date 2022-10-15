define(['assets/js/scripts/lib/knockout'], function (ko) {
    return function (items) {
        let viewModel = {
            isActive: ko.observable(false),
            actions: ko.observableArray(items),
            action: ko.observable('Choose Action'),
            switchDropdown: function () {
                document.body.addEventListener('click', e => {
                    if (!e.target.classList.contains('dropdown-toggle')) {
                        viewModel.isActive(false);
                    }
                })
                viewModel.isActive(!viewModel.isActive());
            },
            chooseAction: function (ev) {
                viewModel.action(ev);
                viewModel.switchDropdown();
            },
            isSelectedItem: function (value) {
                console.log(value);
                // return viewModel.selectedItems().includes(value);
            },
            selectedItems: ko.observableArray([]),
            selectItem: function (value) {
                if (viewModel.isSelectedItem(value)) {
                    viewModel.selectedItems().filter(item => item!==value);
                    return;
                }
                viewModel.selectedItems.push(value);
                // viewModel.selectedItems.push(value);
            }
        }
        return viewModel;
    }
});