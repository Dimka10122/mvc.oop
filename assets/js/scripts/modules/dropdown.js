define(['assets/js/scripts/lib/knockout'], function (ko) {
    return function () {
        let actions = [
            'Select/Unselect All',
            'Select/Unselect This Page',
        ];

        let viewModel = {
            isActive: ko.observable(false),
            actions: ko.observableArray(actions),
            action: ko.observable('Choose Action'),
            switchDropdown: function () {
                document.body.addEventListener('click', e => {
                    if (!e.target.classList.contains('dropdown-toggle')) {
                        viewModel.isActive(false);
                    }
                })
                viewModel.isActive(!viewModel.isActive());
            },
            chooseAction: function (action) {
                viewModel.action(action);
                viewModel.switchDropdown();
                switch (action) {
                    case 'Select/Unselect All' :
                        return true;
                        break;
                    case 'Select/Unselect This Page':
                        return false;
                        break;
                    default:
                        break;
                }
            },
            isSelectedItem: function (value) {
                console.log(value, viewModel.selectedItems().includes(value))
                return viewModel.selectedItems().includes(value);
            },
            selectedItems: ko.observableArray([]),
            selectItem: function ({id}) {
                if (viewModel.isSelectedItem(id)) {
                    viewModel.selectedItems(viewModel.selectedItems().filter(item => item !== id));
                    return;
                }
                viewModel.selectedItems.push(id);
            },
            selectMoreItems: function (items) {
                items.forEach(item => {
                    viewModel.selectItem(item);
                })
            }
        }
        return viewModel;
    }
});